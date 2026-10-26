<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'role_subtitle',
        'content',
        'avatar',
        'is_approved',
        'status',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
                return $this->avatar;
            }

            return asset('uploads/'.ltrim($this->avatar, '/'));
        }

        if ($this->user && $this->user->avatar) {
            if (str_starts_with($this->user->avatar, 'http://') || str_starts_with($this->user->avatar, 'https://')) {
                return $this->user->avatar;
            }

            return asset('uploads/'.ltrim($this->user->avatar, '/'));
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=CC7A6B&color=ffffff&size=160&bold=true';
    }

    public function getProfileUrlAttribute(): ?string
    {
        if ($this->user) {
            return $this->user->profile_url;
        }

        if ($this->user_id) {
            return route('warga.profile', $this->user_id);
        }

        if (! empty($this->name)) {
            $user = User::where('name', $this->name)->first();
            if ($user) {
                return $user->profile_url;
            }
        }

        return null;
    }
}
