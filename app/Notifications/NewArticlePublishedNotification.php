<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewArticlePublishedNotification extends Notification
{
    use Queueable;

    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_article_from_followed',
            'article_id' => $this->article->id,
            'title' => $this->article->title,
            'slug' => $this->article->slug,
            'article_title' => $this->article->title,
            'article_slug' => $this->article->slug,
            'article_url' => $this->article->url,
            'author_id' => $this->article->user_id,
            'author_name' => $this->article->user->name ?? 'Warga',
            'author_username' => $this->article->user->username ?? '',
            'author_avatar' => $this->article->user->avatar_url ?? '',
            'message' => ($this->article->user->name ?? 'Penulis yang Anda ikuti').' baru saja menerbitkan tulisan: "'.$this->article->title.'"',
            'published_at' => ($this->article->published_at ?? now())->format('d M Y, H:i'),
        ];
    }
}
