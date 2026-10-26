<?php

use App\Http\Controllers\Admin\AdSettingController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\ArticleReportController as AdminArticleReportController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Warga\ArticleController as WargaArticleController;
use App\Http\Controllers\Warga\CommentController as WargaCommentController;
use App\Http\Controllers\Warga\TestimonialController as WargaTestimonialController;
use App\Models\ArticleLike;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [ArticleController::class, 'beritaArchive'])->name('berita.index');
Route::get('/jurnal', function (Request $request) {
    $queryString = $request->getQueryString();

    return redirect()->to('/berita'.($queryString ? '?'.$queryString : ''), 301);
})->name('jurnal.index');
Route::get('/suara-warga/suggest', [ArticleController::class, 'searchSuggest'])->name('suara-warga.suggest');
Route::get('/suara-warga', [ArticleController::class, 'suaraWargaArchive'])->name('suara-warga.index');
Route::get('/berita/{slug}', [ArticleController::class, 'showBerita'])->name('berita.show');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::post('/artikel/{id}/like', [ArticleController::class, 'toggleLike'])->name('articles.like');
Route::get('/artikel/{id}/stats', [ArticleController::class, 'stats'])->name('articles.stats');
Route::post('/artikel/{id}/komentar', [ArticleController::class, 'storeComment'])->name('articles.comment');
Route::post('/artikel/{id}/laporkan', [ArticleController::class, 'report'])->name('articles.report');

Route::post('/testimoni', [TestimonialController::class, 'store'])->name('testimonials.store');

Route::get('/profil-sekolah', [HomeController::class, 'profileSchool'])->name('profil-sekolah');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::get('/syarat-ketentuan', [HomeController::class, 'terms'])->name('terms');
Route::get('/kebijakan-privasi', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/pedoman-komunitas', [HomeController::class, 'pedomanKomunitas'])->name('pedoman-komunitas');
Route::get('/panduan-suara-warga', [HomeController::class, 'panduanSuaraWarga'])->name('panduan-suara-warga');
Route::get('/sop', [HomeController::class, 'sop'])->name('sop');
Route::redirect('/standar-pelayanan', '/sop', 301);
Route::redirect('/standar-operasional-pelayanan', '/sop', 301);
Route::get('/api/pengumuman-aktif', [HomeController::class, 'activeAnnouncement'])->name('announcements.active');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/icon.png', function () {
    $path = base_path('icon.png');
    if (! file_exists($path)) {
        $path = public_path('icon.png');
    }

    return response()->file($path, [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'public, max-age=86400',
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        $articles = $user->articles()->with('category')->latest()->take(5)->get();
        $totalLikes = (int) $user->articles()->sum('likes_count');
        $totalArticles = $user->articles()->count();
        $userArticleIds = $user->articles()->pluck('id');
        $totalComments = Comment::whereIn('article_id', $userArticleIds)->count();

        $recentComments = Comment::with(['article', 'user'])
            ->whereIn('article_id', $userArticleIds)
            ->latest()
            ->take(3)
            ->get();

        $recentLikes = ArticleLike::with(['article', 'user'])
            ->whereIn('article_id', $userArticleIds)
            ->latest()
            ->take(3)
            ->get();

        $score = 40;
        if (! empty($user->avatar)) {
            $score += 20;
        }
        if (! empty($user->bio)) {
            $score += 20;
        }
        if (! empty($user->nisn) || ! empty($user->nip) || ! empty($user->tahun_lulus)) {
            $score += 20;
        }
        $profileCompleteness = min(100, $score);

        return view('dashboard', compact(
            'user',
            'articles',
            'totalLikes',
            'totalArticles',
            'totalComments',
            'recentComments',
            'recentLikes',
            'profileCompleteness'
        ));
    })->name('dashboard');

    Route::prefix('warga')->name('warga.')->group(function () {
        Route::resource('articles', WargaArticleController::class);

        Route::get('comments', [WargaCommentController::class, 'index'])->name('comments.index');
        Route::patch('comments/{comment}/approve', [WargaCommentController::class, 'approve'])->name('comments.approve');
        Route::delete('comments/{comment}', [WargaCommentController::class, 'destroy'])->name('comments.destroy');

        Route::resource('testimonials', WargaTestimonialController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/warga/{username}/follow', [ProfileController::class, 'toggleFollow'])
        ->where('username', '^(?!(articles|comments|testimonials)$).*$')
        ->name('warga.follow');

    Route::post('/notifikasi/{id}/read', [ProfileController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::post('/notifikasi/read-all', [ProfileController::class, 'markAllNotificationsAsRead'])->name('notifications.read-all');
});

Route::get('/warga/{username}', [ProfileController::class, 'showPublic'])
    ->where('username', '^(?!(articles|comments|testimonials)$).*$')
    ->name('warga.profile');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::post('/articles/{article}/moderate', [AdminArticleController::class, 'moderate'])->name('articles.moderate');
    Route::resource('articles', AdminArticleController::class);

    Route::resource('agendas', AdminAgendaController::class);

    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}', [AdminCommentController::class, 'updateStatus'])->name('comments.status');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('/reports', [AdminArticleReportController::class, 'index'])->name('reports.index');
    Route::patch('/reports/{report}/status', [AdminArticleReportController::class, 'updateStatus'])->name('reports.status');
    Route::delete('/reports/{report}', [AdminArticleReportController::class, 'destroy'])->name('reports.destroy');

    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::patch('/testimonials/{testimonial}/toggle-approval', [AdminTestimonialController::class, 'toggleApproval'])->name('testimonials.toggle-approval');
    Route::post('/testimonials/{testimonial}/reject', [AdminTestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

    Route::patch('/pages/{page}/toggle-status', [AdminPageController::class, 'toggleStatus'])->name('pages.toggle-status');
    Route::resource('pages', AdminPageController::class);

    Route::patch('/announcements/{announcement}/toggle-status', [AdminAnnouncementController::class, 'toggleStatus'])->name('announcements.toggle-status');
    Route::resource('announcements', AdminAnnouncementController::class);

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/activation', [AdminUserController::class, 'toggleActivation'])->name('users.activation');
    Route::patch('/users/{user}/verify-email', [AdminUserController::class, 'toggleEmailVerification'])->name('users.verify-email');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/pengaturan-iklan', [AdSettingController::class, 'index'])->name('ads.index');
    Route::post('/pengaturan-iklan', [AdSettingController::class, 'update'])->name('ads.update');
});

require __DIR__.'/auth.php';

Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!(admin|warga|dashboard|login|logout|register|password|verify-email|confirm-password|forgot-password|reset-password|berita|artikel|suara-warga|jurnal|testimoni|profil-sekolah|kontak|syarat-ketentuan|kebijakan-privasi|pedoman-komunitas|panduan-suara-warga|sitemap|sitemap\.xml|icon|icon\.png|notifikasi|profile|pengaturan-iklan|storage|up|api|pengumuman)$).*$')
    ->name('pages.show');
