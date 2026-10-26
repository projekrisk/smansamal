<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleReport;
use Illuminate\Http\Request;

class ArticleReportController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $reason = $request->query('reason');
        $search = $request->query('q');

        $query = ArticleReport::with(['article.user', 'user', 'reviewer']);

        if ($status && in_array($status, ['pending', 'reviewed', 'resolved', 'dismissed'])) {
            $query->where('status', $status);
        }

        if ($reason && in_array($reason, ['spam', 'inappropriate', 'hate_speech', 'hoax', 'plagiarism', 'other'])) {
            $query->where('reason', $reason);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('article', function ($aq) use ($search) {
                    $aq->where('title', 'like', "%{$search}%");
                })
                    ->orWhere('reporter_name', 'like', "%{$search}%")
                    ->orWhere('reporter_email', 'like', "%{$search}%")
                    ->orWhere('details', 'like', "%{$search}%");
            });
        }

        $totalCount = ArticleReport::count();
        $pendingCount = ArticleReport::where('status', 'pending')->count();
        $reviewedCount = ArticleReport::where('status', 'reviewed')->count();
        $resolvedCount = ArticleReport::where('status', 'resolved')->count();
        $dismissedCount = ArticleReport::where('status', 'dismissed')->count();

        $reports = $query->latest()->paginate(20)->withQueryString();

        return view('admin.reports.index', compact(
            'reports',
            'status',
            'reason',
            'search',
            'totalCount',
            'pendingCount',
            'reviewedCount',
            'resolvedCount',
            'dismissedCount'
        ));
    }

    public function updateStatus(Request $request, ArticleReport $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
            'article_action' => 'nullable|in:none,unpublish,delete',
        ]);

        $articleAction = $validated['article_action'] ?? 'none';
        $actionMessage = '';

        if ($report->article) {
            if ($articleAction === 'unpublish') {
                $report->article->update(['status' => 'draft']);
                $actionMessage = ' Artikel berhasil ditarik ke status draft.';
            } elseif ($articleAction === 'delete') {
                $report->article->delete();
                $actionMessage = ' Artikel berhasil dihapus.';
            }
        }

        $report->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $report->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.'.$actionMessage);
    }

    public function destroy(ArticleReport $report)
    {
        $report->delete();

        return back()->with('success', 'Laporan berhasil dihapus dari sistem.');
    }
}
