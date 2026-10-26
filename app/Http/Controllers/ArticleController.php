<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\ArticleReport;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\ArticleReportedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function beritaArchive(Request $request)
    {
        $categories = Category::whereIn('type', ['jurnal', 'both'])
            ->whereHas('articles', function ($q) {
                $q->published()->jurnal();
            })
            ->get();
        $selectedCategory = $request->query('kategori');
        $search = $request->query('q');

        $query = Article::with(['category', 'user'])
            ->published()
            ->jurnal();

        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest('published_at')->paginate(6)->withQueryString();

        if ($request->ajax() || $request->has('load_more')) {
            $html = '';
            foreach ($articles as $article) {
                $html .= view('components.article-card-jurnal', ['article' => $article])->render();
            }

            return response()->json([
                'html' => $html,
                'next_page_url' => $articles->nextPageUrl(),
                'has_more' => $articles->hasMorePages(),
                'total' => $articles->total(),
            ]);
        }

        return view('articles.arsip-berita', compact('articles', 'categories', 'selectedCategory', 'search'));
    }

    public function jurnalArchive(Request $request)
    {
        return $this->beritaArchive($request);
    }

    public function suaraWargaArchive(Request $request)
    {
        $selectedCategory = $request->query('kategori');
        $selectedTag = $request->query('tag');
        $search = $request->query('q');

        $categories = Category::whereIn('type', ['suara_warga', 'both'])
            ->whereHas('articles', function ($q) {
                $q->published()->suaraWarga();
            })
            ->get();

        $getSpotlight = function ($days = null) {
            $q = Article::with(['category', 'user', 'tags'])
                ->withCount(['comments' => function ($cq) {
                    $cq->where('status', 'approved');
                }])
                ->published()
                ->suaraWarga();

            if ($days) {
                $q->where('published_at', '>=', now()->subDays($days));
            }

            return $q->orderByRaw('(views_count + (likes_count * 3) + ((SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id AND comments.status = "approved") * 4)) DESC')
                ->orderByDesc('views_count')
                ->orderByDesc('published_at')
                ->first();
        };

        $spotlight = $getSpotlight(7);

        if (! $spotlight) {
            $spotlight = $getSpotlight(30);
        }

        if (! $spotlight) {
            $spotlight = $getSpotlight(null);
        }

        $query = Article::with(['category', 'user', 'tags'])
            ->published()
            ->suaraWarga();

        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        if ($selectedTag) {
            $cleanTag = ltrim(trim($selectedTag), '#');
            $query->whereHas('tags', function ($q) use ($cleanTag) {
                $q->where('slug', Str::slug($cleanTag))
                    ->orWhere('name', 'like', "%{$cleanTag}%");
            });
        }

        if ($search) {
            $cleanSearch = ltrim(trim($search), '#');
            $query->where(function ($q) use ($cleanSearch) {
                $q->where('title', 'like', "%{$cleanSearch}%")
                    ->orWhere('excerpt', 'like', "%{$cleanSearch}%")
                    ->orWhere('content', 'like', "%{$cleanSearch}%")
                    ->orWhereHas('tags', function ($tq) use ($cleanSearch) {
                        $tq->where('name', 'like', "%{$cleanSearch}%")
                            ->orWhere('slug', 'like', '%'.Str::slug($cleanSearch).'%');
                    });
            });
        }

        $articles = $query->latest('published_at')->paginate(6)->withQueryString();

        if ($request->ajax() || $request->has('load_more')) {
            $html = '';
            foreach ($articles as $article) {
                $html .= view('components.article-card-suara-warga', [
                    'article' => $article,
                    'layout' => 'horizontal',
                ])->render();
            }

            return response()->json([
                'html' => $html,
                'next_page_url' => $articles->nextPageUrl(),
                'has_more' => $articles->hasMorePages(),
                'total' => $articles->total(),
            ]);
        }

        $popularArticlesMonth = Article::with(['category', 'user', 'tags'])
            ->published()
            ->suaraWarga()
            ->where('published_at', '>=', now()->subDays(30))
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        if ($popularArticlesMonth->count() < 3) {
            $fallback = Article::with(['category', 'user', 'tags'])
                ->published()
                ->suaraWarga()
                ->whereNotIn('id', $popularArticlesMonth->pluck('id'))
                ->orderByDesc('views_count')
                ->take(5 - $popularArticlesMonth->count())
                ->get();
            $popularArticlesMonth = $popularArticlesMonth->merge($fallback);
        }

        $activeAuthors = User::whereNotIn('role_type', ['admin', 'super_admin'])
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['Admin', 'Super Admin']);
            })
            ->whereHas('articles', function ($q) {
                $q->published()->suaraWarga();
            })
            ->withCount(['articles' => function ($q) {
                $q->published()->suaraWarga();
            }])
            ->orderByDesc('articles_count')
            ->take(5)
            ->get();

        $popularTags = Tag::whereHas('articles', function ($q) {
            $q->published()->suaraWarga();
        })
            ->withCount(['articles' => function ($q) {
                $q->published()->suaraWarga();
            }])
            ->orderByDesc('articles_count')
            ->take(12)
            ->get();

        $recentTags = Tag::whereHas('articles', function ($q) {
            $q->published()->suaraWarga();
        })
            ->latest('id')
            ->take(8)
            ->get();

        return view('articles.suara-warga', compact(
            'articles',
            'spotlight',
            'categories',
            'selectedCategory',
            'selectedTag',
            'search',
            'activeAuthors',
            'popularArticlesMonth',
            'popularTags',
            'recentTags'
        ));
    }

    public function searchSuggest(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $cleanQ = ltrim($q, '#');

        if (mb_strlen($cleanQ) < 2) {
            return response()->json([
                'articles' => [],
                'tags' => [],
            ]);
        }

        $tags = Tag::whereHas('articles', function ($aq) {
            $aq->published()->suaraWarga();
        })
            ->where(function ($query) use ($cleanQ) {
                $query->where('name', 'like', "%{$cleanQ}%")
                    ->orWhere('slug', 'like', '%'.Str::slug($cleanQ).'%');
            })
            ->withCount(['articles' => function ($aq) {
                $aq->published()->suaraWarga();
            }])
            ->orderByDesc('articles_count')
            ->take(6)
            ->get()
            ->map(function ($tag) {
                return [
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'count' => $tag->articles_count,
                    'url' => route('suara-warga.index', ['tag' => $tag->slug]),
                ];
            });

        $articles = Article::with(['category', 'user', 'tags'])
            ->published()
            ->suaraWarga()
            ->where(function ($query) use ($cleanQ) {
                $query->where('title', 'like', "%{$cleanQ}%")
                    ->orWhere('excerpt', 'like', "%{$cleanQ}%")
                    ->orWhereHas('tags', function ($tq) use ($cleanQ) {
                        $tq->where('name', 'like', "%{$cleanQ}%")
                            ->orWhere('slug', 'like', '%'.Str::slug($cleanQ).'%');
                    })
                    ->orWhereHas('user', function ($uq) use ($cleanQ) {
                        $uq->where('name', 'like', "%{$cleanQ}%");
                    });
            })
            ->orderByDesc('views_count')
            ->latest('published_at')
            ->take(6)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'url' => $article->url,
                    'category' => $article->category->name ?? 'Suara Warga',
                    'author' => $article->user->name ?? 'Warga',
                    'date' => $article->formatted_date,
                    'views' => $article->views_count,
                    'tags' => $article->tags->pluck('name')->take(3),
                ];
            });

        return response()->json([
            'articles' => $articles,
            'tags' => $tags,
        ]);
    }

    public function showBerita(string $slug, Request $request)
    {
        $article = Article::with(['category', 'user', 'comments.user', 'comments.replies.user', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        if ($article->type === 'suara_warga') {
            return redirect()->route('articles.show', $slug, 301);
        }

        return $this->renderArticleDetail($article, $request);
    }

    public function show(string $slug, Request $request)
    {
        $article = Article::with(['category', 'user', 'comments.user', 'comments.replies.user', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        if ($article->type === 'jurnal') {
            return redirect()->route('berita.show', $slug, 301);
        }

        return $this->renderArticleDetail($article, $request);
    }

    protected function renderArticleDetail(Article $article, Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user && $user->isAdmin();

        // Artikel yang tidak terbit (status draft, rejected, pending_review, atau jadwal terbit belum tiba)
        // TIDAK BISA dilihat oleh publik (tamu umum / pengunjung belum login / non-admin).
        if (! $article->isPublished()) {
            if (! $user) {
                abort(404);
            }

            // Status draft dan rejected HANYA boleh dipratinjau oleh Admin
            if (in_array($article->status, ['draft', 'rejected']) && ! $isAdmin) {
                abort(404);
            }

            // Status pending_review hanya boleh dilihat oleh Admin atau penulis pemilik artikel
            if ($article->status === 'pending_review' && ! $isAdmin && $user->id !== $article->user_id) {
                abort(404);
            }

            // Status published tapi waktu terbit masih di masa depan hanya boleh dilihat oleh Admin
            if ($article->status === 'published' && ! $isAdmin) {
                abort(404);
            }
        }

        if ($article->isPublished()) {
            $sessionKey = 'viewed_article_'.$article->id;
            if (! session()->has($sessionKey)) {
                $article->increment('views_count');
                session()->put($sessionKey, true);
            }
        }

        $relatedArticles = Article::with('category')
            ->published()
            ->where('type', $article->type)
            ->where('id', '!=', $article->id)
            ->when($article->category_id, fn ($q) => $q->where('category_id', $article->category_id))
            ->latest('published_at')
            ->take(2)
            ->get();

        if ($relatedArticles->count() < 2) {
            $extra = Article::with('category')
                ->published()
                ->where('type', $article->type)
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->latest('published_at')
                ->take(2 - $relatedArticles->count())
                ->get();
            $relatedArticles = $relatedArticles->merge($extra);
        }

        $user = auth()->user();
        $isLiked = $article->isLikedByUser($user, $request->ip());

        $viewName = ($article->type === 'suara_warga')
            ? 'articles.detail-suara-warga'
            : 'articles.detail-berita';

        return view($viewName, compact('article', 'relatedArticles', 'isLiked'));
    }

    public function toggleLike(int $id, Request $request)
    {
        $article = Article::findOrFail($id);
        if (! $article->isPublished() && ! auth()->user()?->isAdmin()) {
            abort(404);
        }

        $user = auth()->user();
        $ip = $request->ip();

        $likeQuery = ArticleLike::where('article_id', $article->id);
        if ($user) {
            $likeQuery->where('user_id', $user->id);
        } else {
            $likeQuery->where('ip_address', $ip);
        }

        $existingLike = $likeQuery->first();

        if ($existingLike) {
            $existingLike->delete();
            $article->decrement('likes_count');
            $liked = false;
        } else {
            ArticleLike::create([
                'article_id' => $article->id,
                'user_id' => $user?->id,
                'ip_address' => $ip,
            ]);
            $article->increment('likes_count');
            $liked = true;
        }

        $likesCount = $article->fresh()->likes_count;

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $likesCount,
            ]);
        }

        return back();
    }

    public function stats(Request $request, int $id)
    {
        $article = Article::select('id', 'views_count', 'likes_count', 'status', 'published_at')->findOrFail($id);
        if (! $article->isPublished() && ! auth()->user()?->isAdmin()) {
            abort(404);
        }

        $user = auth()->user();
        $ip = $request->ip();

        $likeQuery = ArticleLike::where('article_id', $article->id);
        if ($user) {
            $likeQuery->where('user_id', $user->id);
        } else {
            $likeQuery->where('ip_address', $ip);
        }

        return response()->json([
            'success' => true,
            'views_count' => (int) ($article->views_count ?? 0),
            'likes_count' => (int) ($article->likes_count ?? 0),
            'comments_count' => (int) $article->comments()->count(),
            'liked' => $likeQuery->exists(),
        ]);
    }

    public function storeComment(Request $request, int $id)
    {
        $article = Article::findOrFail($id);
        if (! $article->isPublished() && ! auth()->user()?->isAdmin()) {
            abort(404);
        }

        $user = auth()->user();

        $rules = [
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ];

        if (! $user) {
            $rules['author_name'] = 'required|string|max:100';
            $rules['author_email'] = 'nullable|email|max:150';
        }

        $validated = $request->validate($rules);

        $status = $user ? 'approved' : 'pending';

        $comment = Comment::create([
            'article_id' => $article->id,
            'user_id' => $user?->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'author_name' => $user ? $user->name : $validated['author_name'],
            'author_email' => $user ? $user->email : ($validated['author_email'] ?? null),
            'content' => $validated['content'],
            'status' => $status,
        ]);

        if ($status === 'approved') {
            $comment->sendNotifications();
        }

        $message = $user
            ? 'Komentar Anda berhasil dikirim.'
            : 'Komentar Anda telah diterima dan akan ditayangkan setelah disetujui oleh moderator atau penulis artikel.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $status,
                'comments_count' => (int) $article->comments()->count(),
            ]);
        }

        return back()->with('success', $message);
    }

    public function report(Request $request, int $id)
    {
        $article = Article::findOrFail($id);
        if (! $article->isPublished() && ! auth()->user()?->isAdmin()) {
            abort(404);
        }

        $user = auth()->user();
        $ip = $request->ip();

        $rules = [
            'reason' => 'required|string|in:spam,inappropriate,hate_speech,hoax,plagiarism,other',
            'details' => 'nullable|string|max:1000',
        ];

        if (! $user) {
            $rules['reporter_name'] = 'nullable|string|max:100';
            $rules['reporter_email'] = 'nullable|email|max:150';
        }

        $validated = $request->validate($rules);

        $recentReportQuery = ArticleReport::where('article_id', $article->id)
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subDay());

        if ($user) {
            $recentReportQuery->where('user_id', $user->id);
        } else {
            $recentReportQuery->where('ip_address', $ip);
        }

        if ($recentReportQuery->exists()) {
            $warningMsg = 'Laporan Anda untuk artikel ini sudah kami terima sebelumnya dan sedang ditinjau.';
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $warningMsg,
                ], 422);
            }

            return back()->with('warning', $warningMsg);
        }

        $report = ArticleReport::create([
            'article_id' => $article->id,
            'user_id' => $user?->id,
            'reporter_name' => $user ? $user->name : ($validated['reporter_name'] ?? null),
            'reporter_email' => $user ? $user->email : ($validated['reporter_email'] ?? null),
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? null,
            'status' => 'pending',
            'ip_address' => $ip,
        ]);

        $admins = User::whereIn('role_type', ['admin', 'super_admin'])
            ->orWhereHas('roles', fn ($q) => $q->whereIn('name', ['Admin', 'Super Admin']))
            ->get();

        foreach ($admins as $admin) {
            $admin->notify(new ArticleReportedNotification($report));
        }

        $successMsg = 'Terima kasih. Laporan Anda berhasil dikirim dan akan segera ditinjau oleh tim pengelola.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
            ]);
        }

        return back()->with('success', $successMsg);
    }
}
