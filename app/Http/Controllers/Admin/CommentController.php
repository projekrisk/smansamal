<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Comment::with(['article', 'user']);

        if ($status) {
            $query->where('status', $status);
        }

        $comments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.comments.index', compact('comments', 'status'));
    }

    public function updateStatus(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,pending,spam',
        ]);

        $previousStatus = $comment->status;
        $comment->update($validated);

        if ($validated['status'] === 'approved' && $previousStatus !== 'approved') {
            $comment->sendNotifications();
        }

        return back()->with('success', 'Status komentar diperbarui.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
