<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, $default = null): ?string
    {
        return Cache::remember("setting_{$key}", 86400, function () use ($key, $default) {
            $record = static::where('key', $key)->first();

            return $record !== null ? $record->value : $default;
        });
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting_{$key}");
        Cache::forget('settings_all');
    }

    public static function getAll(): array
    {
        return Cache::remember('settings_all', 86400, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function getBool(string $key, bool $default = false): bool
    {
        $val = static::get($key);
        if ($val === null) {
            return $default;
        }

        return filter_var($val, FILTER_VALIDATE_BOOLEAN) || $val === '1' || $val === 'true' || $val === 'on';
    }
}
