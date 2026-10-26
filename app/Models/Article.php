<?php

namespace App\Models;

use App\Notifications\NewArticlePublishedNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_mode',
        'featured_image_caption',
        'status',
        'is_featured',
        'views_count',
        'likes_count',
        'rejection_reason',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
            'likes_count' => 'integer',
        ];
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $baseSlug = Str::slug($article->title);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }
                $article->slug = $slug;
            }

            if (empty($article->excerpt) && ! empty($article->content)) {
                $article->excerpt = Str::limit(strip_tags($article->content), 160);
            }

            if ($article->status === 'published' && empty($article->published_at)) {
                $article->published_at = now();
            }
        });

        static::saving(function ($article) {
            if ($article->status === 'published' && empty($article->published_at)) {
                $article->published_at = now();
            }
        });

        static::saved(function () {
            Cache::forget('home_jurnal_articles');
            Cache::forget('home_suara_warga_articles');
            Cache::forget('sitemap_xml_content');
        });

        static::deleted(function () {
            Cache::forget('home_jurnal_articles');
            Cache::forget('home_suara_warga_articles');
            Cache::forget('sitemap_xml_content');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->where('status', 'approved')->latest();
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ArticleLike::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ArticleReport::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function getTagsStringAttribute(): string
    {
        return $this->tags->pluck('name')->implode(', ');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeJurnal(Builder $query): Builder
    {
        return $query->where('type', 'jurnal');
    }

    public function scopeSuaraWarga(Builder $query): Builder
    {
        return $query->where('type', 'suara_warga');
    }

    public function scopePendingReview(Builder $query): Builder
    {
        return $query->where('status', 'pending_review');
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            if (str_starts_with($this->featured_image, 'http://') || str_starts_with($this->featured_image, 'https://')) {
                return $this->featured_image;
            }

            return asset('uploads/'.ltrim($this->featured_image, '/'));
        }

        return asset('images/og-default.jpg');
    }

    public function getUrlAttribute(): string
    {
        if ($this->type === 'jurnal') {
            return route('berita.show', $this->slug);
        }

        return route('articles.show', $this->slug);
    }

    public function getFormattedDateAttribute(): string
    {
        $date = $this->published_at ?? $this->created_at;

        return Carbon::parse($date)->locale('id')->isoFormat('D MMM Y');
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content));

        return max(1, (int) ceil($words / 200));
    }

    public static function wrapTables(string $content): string
    {
        if (empty($content) || stripos($content, '<table') === false) {
            return $content;
        }

        if (str_contains($content, 'prose-table-wrap')) {
            $content = preg_replace('/<div\s+class=["\']prose-table-wrap["\']\s*>\s*(<table\b[^>]*>.*?<\/table>)\s*<\/div>/is', '$1', $content) ?? $content;
        }

        return preg_replace('/(<table\b[^>]*>.*?<\/table>)/is', '<div class="prose-table-wrap">$1</div>', $content) ?? $content;
    }

    public function getContentWithAdsAttribute(): string
    {
        $content = $this->content ?? '';

        if (! Setting::getBool('ad_in_article_enabled')) {
            return self::wrapTables($content);
        }

        $adCode = trim(Setting::get('ad_in_article_code', ''));
        if (empty($adCode)) {
            return self::wrapTables($content);
        }

        $targetParagraph = max(1, (int) Setting::get('ad_in_article_paragraph', 2));

        $adHtml = '<div class="my-8 py-5 px-4 text-center bg-stone-50 rounded-2xl border border-stone-200/80 overflow-hidden not-prose ad-container ad-in-article shadow-xs">'
            .'<span class="text-[10px] uppercase font-bold tracking-widest text-stone-400 block mb-2.5">Iklan</span>'
            .$adCode
            .'</div>';

        $parts = preg_split('/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        if (! $parts || count($parts) < 2) {
            return self::wrapTables($content.$adHtml);
        }

        $pCount = 0;
        $result = '';
        $inserted = false;

        for ($i = 0; $i < count($parts); $i++) {
            $result .= $parts[$i];
            if (strtolower($parts[$i]) === '</p>') {
                $pCount++;
                if ($pCount === $targetParagraph && ! $inserted) {
                    $result .= $adHtml;
                    $inserted = true;
                }
            }
        }

        if (! $inserted) {
            $result .= $adHtml;
        }

        return self::wrapTables($result);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at !== null
            && $this->published_at->lte(now());
    }

    public function isLikedByUser(?User $user, ?string $ip = null): bool
    {
        if ($user) {
            return $this->likes()->where('user_id', $user->id)->exists();
        }
        if ($ip) {
            return $this->likes()->where('ip_address', $ip)->exists();
        }

        return false;
    }

    public function notifyFollowers(): void
    {
        if ($this->status !== 'published') {
            return;
        }

        $author = $this->user;
        if (! $author) {
            return;
        }

        $followers = $author->followers()->get();
        foreach ($followers as $follower) {

            if ($follower->id === $author->id) {
                continue;
            }

            $alreadyNotified = $follower->notifications()
                ->where('data->article_id', $this->id)
                ->exists();

            if (! $alreadyNotified) {
                $follower->notify(new NewArticlePublishedNotification($this));
            }
        }
    }
}
