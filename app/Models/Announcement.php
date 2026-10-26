<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'image',
        'button_text',
        'button_url',
        'is_active',
        'start_at',
        'end_at',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'views_count' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_at')
                    ->orWhere('start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_at')
                    ->orWhere('end_at', '>=', now());
            });
    }

    public function scopeForPopup(Builder $query): Builder
    {
        return $query->whereIn('type', ['popup', 'both']);
    }

    public function scopeForFloating(Builder $query): Builder
    {
        return $query->whereIn('type', ['floating', 'both']);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'floating' => 'Pengumuman Melayang',
            'both' => 'Popup & Melayang',
            default => 'Popup Saat Dibuka',
        };
    }

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('uploads/'.ltrim($this->image, '/'));
    }
}
