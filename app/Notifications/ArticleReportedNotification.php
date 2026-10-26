<?php

namespace App\Notifications;

use App\Models\ArticleReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ArticleReportedNotification extends Notification
{
    use Queueable;

    public ArticleReport $report;

    public function __construct(ArticleReport $report)
    {
        $this->report = $report;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $article = $this->report->article;
        $reporterName = $this->report->effective_reporter_name;

        return [
            'type' => 'article_reported',
            'report_id' => $this->report->id,
            'article_id' => $article->id,
            'article_title' => $article->title,
            'article_slug' => $article->slug,
            'article_url' => route('admin.reports.index', ['status' => 'pending', 'report_id' => $this->report->id]),
            'author_id' => $this->report->user_id,
            'author_name' => $reporterName,
            'author_avatar' => $this->report->user?->avatar_url
                ?? ('https://ui-avatars.com/api/?name='.urlencode($reporterName).'&background=DC2626&color=fff'),
            'reason' => $this->report->reason,
            'reason_label' => $this->report->reason_label,
            'message' => 'melaporkan artikel "'.Str::limit($article->title, 40).'" karena: '.$this->report->reason_label,
            'details' => Str::limit($this->report->details, 100),
            'created_at' => now()->format('d M Y, H:i'),
        ];
    }
}
