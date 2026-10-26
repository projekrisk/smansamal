<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('admin_dashboard_stats', 60, function () {
            return [
                'total_jurnal' => Article::jurnal()->published()->count(),
                'total_suara_warga' => Article::suaraWarga()->published()->count(),
                'pending_suara_warga' => Article::suaraWarga()->where('status', 'pending_review')->count(),
                'total_comments' => Comment::count(),
                'pending_comments' => Comment::where('status', 'pending')->count(),
                'total_users' => User::count(),
                'new_users_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
                'pending_users' => User::where('is_active', false)->whereNotIn('role_type', ['admin', 'super_admin'])->count(),
                'active_agendas' => Agenda::active()->where('event_date', '>=', now()->startOfMonth())->count(),
                'total_views' => Article::sum('views_count'),
                'total_likes' => Article::sum('likes_count'),
            ];
        });

        $pendingArticles = Article::with(['user', 'category'])
            ->where('status', 'pending_review')
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        $jurnalArticles = Article::with(['user', 'category'])
            ->where('type', 'jurnal')
            ->latest()
            ->take(5)
            ->get();

        $moderationComments = Comment::with(['article', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'pendingArticles',
            'recentUsers',
            'jurnalArticles',
            'moderationComments'
        ));
    }
}
