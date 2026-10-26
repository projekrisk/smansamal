<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)->withTimestamps();
    }

    public static function parseAndSync(Article $article, ?string $tagString): array
    {
        if (empty(trim($tagString ?? ''))) {
            $article->tags()->sync([]);

            return [];
        }

        $rawTags = preg_split('/[,;\n]+/', $tagString);
        $tagIds = [];

        foreach ($rawTags as $rawTag) {
            $cleaned = trim($rawTag);
            $cleaned = ltrim($cleaned, '#');
            $cleaned = trim($cleaned);

            if (empty($cleaned)) {
                continue;
            }

            $slug = Str::slug($cleaned);
            if (empty($slug)) {
                continue;
            }

            $tag = static::firstOrCreate(
                ['slug' => $slug],
                ['name' => $cleaned]
            );

            $tagIds[] = $tag->id;
        }

        $article->tags()->sync($tagIds);

        return $tagIds;
    }
}
