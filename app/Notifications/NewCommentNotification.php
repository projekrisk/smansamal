<?php

namespace App\Notifications;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewCommentNotification extends Notification
{
    use Queueable;

    public Article $article;

    public Comment $comment;

    public function __construct(Article $article, Comment $comment)
    {
        $this->article = $article;
        $this->comment = $comment;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $authorName = $this->comment->author_name;
        $avatar = $this->comment->user?->avatar_url
            ?? ('https://ui-avatars.com/api/?name='.urlencode($authorName).'&background=2D5A27&color=fff');

        return [
            'type' => 'new_comment',
            'comment_id' => $this->comment->id,
            'article_id' => $this->article->id,
            'title' => $this->article->title,
            'slug' => $this->article->slug,
            'article_title' => $this->article->title,
            'article_slug' => $this->article->slug,
            'article_url' => $this->article->url.'#comment-'.$this->comment->id,
            'author_id' => $this->comment->user_id,
            'author_name' => $authorName,
            'author_avatar' => $avatar,
            'message' => 'mengomentari artikel Anda: "'.Str::limit($this->article->title, 40).'"',
            'comment_snippet' => Str::limit($this->comment->content, 80),
            'created_at' => now()->format('d M Y, H:i'),
        ];
    }
}
