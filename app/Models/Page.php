<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description',
        'is_active',
        'is_system',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_system' => 'boolean',
            'views_count' => 'integer',
        ];
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug) && ! empty($page->title)) {
                $base = Str::slug($page->title);
                $slug = $base;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$counter}";
                    $counter++;
                }
                $page->slug = $slug;
            }
        });

        static::saved(function () {
            Cache::forget('sitemap_xml_content');
        });

        static::deleted(function () {
            Cache::forget('sitemap_xml_content');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getPublicUrlAttribute(): string
    {
        return match ($this->slug) {
            'kontak' => route('contact'),
            'profil-sekolah' => route('profil-sekolah'),
            'syarat-ketentuan' => route('terms'),
            'kebijakan-privasi' => route('privacy'),
            'pedoman-komunitas' => route('pedoman-komunitas'),
            'panduan-suara-warga' => route('panduan-suara-warga'),
            default => route('pages.show', $this->slug),
        };
    }
}
