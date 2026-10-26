<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'reporter_name',
        'reporter_email',
        'reason',
        'details',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
        'ip_address',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getEffectiveReporterNameAttribute(): string
    {
        return $this->user?->name ?? $this->reporter_name ?? 'Warga Anonim';
    }

    public function getEffectiveReporterEmailAttribute(): ?string
    {
        return $this->user?->email ?? $this->reporter_email;
    }

    public function getReasonLabelAttribute(): string
    {
        return match ($this->reason) {
            'spam' => 'Spam / Iklan Tidak Relevan',
            'inappropriate' => 'Konten Tidak Pantas / Asusila',
            'hate_speech' => 'Ujaran Kebencian / SARA',
            'hoax' => 'Informasi Palsu / Misinformasi',
            'plagiarism' => 'Plagiarisme / Pelanggaran Hak Cipta',
            default => 'Pelanggaran Lainnya',
        };
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending' => [
                'label' => 'Menunggu Tindakan',
                'class' => 'bg-amber-50 text-amber-800 border border-amber-200',
            ],
            'reviewed' => [
                'label' => 'Sedang Ditinjau',
                'class' => 'bg-blue-50 text-blue-800 border border-blue-200',
            ],
            'resolved' => [
                'label' => 'Ditindaklanjuti',
                'class' => 'bg-emerald-50 text-emerald-800 border border-emerald-200',
            ],
            'dismissed' => [
                'label' => 'Diabaikan',
                'class' => 'bg-stone-100 text-stone-600 border border-stone-200',
            ],
            default => [
                'label' => ucfirst($this->status),
                'class' => 'bg-stone-100 text-stone-700',
            ],
        };
    }
}
