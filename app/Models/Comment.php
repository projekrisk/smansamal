<?php

namespace App\Models;

use App\Notifications\CommentRepliedNotification;
use App\Notifications\NewCommentNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'parent_id',
        'author_name',
        'author_email',
        'content',
        'status',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('status', 'approved')->oldest();
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->locale('id')->isoFormat('D MMM Y');
    }

    public function getInitialAttribute(): string
    {
        return strtoupper(substr(trim($this->author_name), 0, 1) ?: 'W');
    }

    public function isAuthor(): bool
    {
        return $this->user_id && $this->article && $this->user_id === $this->article->user_id;
    }

    public function getProfileUrlAttribute(): ?string
    {
        return $this->user ? $this->user->profile_url : null;
    }

    public function sendNotifications(): void
    {
        if ($this->status !== 'approved') {
            return;
        }

        $article = $this->article;
        if (! $article) {
            return;
        }

        if ($this->parent_id) {
            $parent = $this->parent()->with('user')->first();

            if ($parent && $parent->user_id && $parent->user_id !== $this->user_id) {
                $parent->user->notify(new CommentRepliedNotification($article, $this, $parent));
            }

            if ($article->user_id
                && $article->user_id !== $this->user_id
                && (! $parent || $article->user_id !== $parent->user_id)) {
                $article->user->notify(new NewCommentNotification($article, $this));
            }

            return;
        }

        if ($article->user_id && $article->user_id !== $this->user_id) {
            $article->user->notify(new NewCommentNotification($article, $this));
        }
    }
}
