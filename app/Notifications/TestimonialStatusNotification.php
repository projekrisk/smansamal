<?php

namespace App\Notifications;

use App\Models\Testimonial;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TestimonialStatusNotification extends Notification
{
    use Queueable;

    public Testimonial $testimonial;

    public string $status;

    public function __construct(Testimonial $testimonial, string $status)
    {
        $this->testimonial = $testimonial;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isApproved = $this->status === 'approved';
        $targetUrl = route('warga.testimonials.index');

        $authorAvatar = 'https://ui-avatars.com/api/?name=Redaksi+Sekolah&background=2A5C43&color=fff';

        return [
            'type' => $isApproved ? 'testimonial_approved' : 'testimonial_rejected',
            'testimonial_id' => $this->testimonial->id,
            'status' => $this->status,
            'title' => $isApproved ? 'Testimoni Anda Disetujui' : 'Testimoni Anda Ditolak Redaksi',
            'target_url' => $targetUrl,
            'article_url' => $targetUrl,
            'author_id' => null,
            'author_name' => 'Tim Redaksi SMAN 1 Malingping',
            'author_avatar' => $authorAvatar,
            'rejection_reason' => $this->testimonial->rejection_reason,
            'message' => $isApproved
                ? 'Testimoni alumni Anda telah disetujui dan ditayangkan di beranda sekolah.'
                : 'Testimoni alumni Anda ditolak redaksi: "'.Str::limit((string) $this->testimonial->rejection_reason, 90).'"',
            'content_snippet' => Str::limit($this->testimonial->content, 80),
            'created_at' => now()->format('d M Y, H:i'),
        ];
    }
}
