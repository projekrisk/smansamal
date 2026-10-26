<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $userArticleIds = $user->articles()->pluck('id');

        $status = $request->query('status');
        $query = Comment::with(['article', 'user'])
            ->whereIn('article_id', $userArticleIds);

        if ($status && in_array($status, ['approved', 'pending'])) {
            $query->where('status', $status);
        }

        if ($request->filled('q')) {
            $search = $request->query('q');
            $query->where(function ($q) use ($search) {
                $q->where('author_name', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('article', function ($sub) use ($search) {
                        $sub->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $comments = $query->latest()->paginate(12)->withQueryString();

        $pendingCount = Comment::whereIn('article_id', $userArticleIds)->where('status', 'pending')->count();
        $approvedCount = Comment::whereIn('article_id', $userArticleIds)->where('status', 'approved')->count();

        return view('warga.comments.index', compact('comments', 'status', 'pendingCount', 'approvedCount'));
    }

    public function approve(Comment $comment): RedirectResponse
    {
        $user = auth()->user();

        if ($comment->article->user_id !== $user->id) {
            abort(403, 'Hanya penulis artikel yang dapat menyetujui komentar ini.');
        }

        $comment->update(['status' => 'approved']);

        return redirect()->route('warga.comments.index')->with('success', 'Komentar berhasil disetujui dan kini tayang ke publik.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $user = auth()->user();

        if ($comment->article->user_id !== $user->id && $comment->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki hak untuk menghapus komentar ini.');
        }

        $comment->delete();

        return redirect()->route('warga.comments.index')->with('success', 'Komentar berhasil dihapus.');
    }
}
