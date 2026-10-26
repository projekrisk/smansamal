<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'time_info',
        'location',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->event_date)->locale('id')->isoFormat('D MMMM Y');
    }

    public function getDayNumberAttribute(): int
    {
        return (int) Carbon::parse($this->event_date)->format('j');
    }

    public function getMonthYearAttribute(): string
    {
        return Carbon::parse($this->event_date)->locale('id')->isoFormat('MMMM Y');
    }
}
