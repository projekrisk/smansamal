<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ImageOptimizerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Article::with(['category', 'user']);

        if ($type) {
            $query->where('type', $type);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $articles = $query->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.articles.index', compact('articles', 'type', 'status', 'search'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request, ImageOptimizerService $imageOptimizer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:jurnal,suara_warga',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_mode' => 'nullable|in:normal,full',
            'featured_image_caption' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,pending_review',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $imageOptimizer->uploadAndConvertToWebp($request->file('featured_image'), 'articles');
        }

        $publishedAt = null;
        if (! empty($validated['published_at'])) {
            $publishedAt = Carbon::parse($validated['published_at']);
        } elseif ($validated['status'] === 'published') {
            $publishedAt = now();
        }

        $baseSlug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $article = Article::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?: Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'featured_image_mode' => $validated['featured_image_mode'] ?? 'normal',
            'featured_image_caption' => $validated['featured_image_caption'] ?? null,
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $publishedAt,
        ]);

        Tag::parseAndSync($article, $request->input('tags'));

        if ($article->status === 'published') {
            $article->notifyFollowers();
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit(Article $article)
    {
        $article->load('tags');
        $categories = Category::all();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article, ImageOptimizerService $imageOptimizer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,'.$article->id,
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:jurnal,suara_warga',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_mode' => 'nullable|in:normal,full',
            'featured_image_caption' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,pending_review,rejected',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'rejection_reason' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:255',
        ]);

        if ($request->filled('slug')) {
            $validated['slug'] = Str::slug($request->input('slug'));
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $imageOptimizer->uploadAndConvertToWebp($request->file('featured_image'), 'articles');
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        if (! empty($validated['published_at'])) {
            $validated['published_at'] = Carbon::parse($validated['published_at']);
        } elseif ($validated['status'] === 'published' && ! $article->published_at) {
            $validated['published_at'] = now();
        }

        $article->update($validated);
        Tag::parseAndSync($article, $request->input('tags'));

        if ($article->status === 'published') {
            $article->notifyFollowers();
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function moderate(Request $request, Article $article)
    {
        $action = $request->input('action');
        $reason = $request->input('rejection_reason');

        if ($action === 'approve') {
            $article->update([
                'status' => 'published',
                'published_at' => $article->published_at ?: now(),
                'rejection_reason' => null,
            ]);

            $article->notifyFollowers();

            $msg = 'Artikel Suara Warga berhasil disetujui dan ditayangkan.';
        } else {
            $article->update([
                'status' => 'rejected',
                'rejection_reason' => $reason ?: 'Belum memenuhi pedoman penulisan sekolah.',
            ]);
            $msg = 'Artikel Suara Warga ditolak.';
        }

        return back()->with('success', $msg);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
