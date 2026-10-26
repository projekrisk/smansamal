<?php

namespace App\Notifications;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class CommentRepliedNotification extends Notification
{
    use Queueable;

    public Article $article;

    public Comment $reply;

    public Comment $parentComment;

    public function __construct(Article $article, Comment $reply, Comment $parentComment)
    {
        $this->article = $article;
        $this->reply = $reply;
        $this->parentComment = $parentComment;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $authorName = $this->reply->author_name;
        $avatar = $this->reply->user?->avatar_url
            ?? ('https://ui-avatars.com/api/?name='.urlencode($authorName).'&background=C85A32&color=fff');

        return [
            'type' => 'comment_reply',
            'comment_id' => $this->reply->id,
            'parent_comment_id' => $this->parentComment->id,
            'article_id' => $this->article->id,
            'title' => $this->article->title,
            'slug' => $this->article->slug,
            'article_title' => $this->article->title,
            'article_slug' => $this->article->slug,
            'article_url' => $this->article->url.'#comment-'.$this->reply->id,
            'author_id' => $this->reply->user_id,
            'author_name' => $authorName,
            'author_avatar' => $avatar,
            'message' => 'membalas komentar Anda di: "'.Str::limit($this->article->title, 40).'"',
            'comment_snippet' => Str::limit($this->reply->content, 80),
            'created_at' => now()->format('d M Y, H:i'),
        ];
    }
}
