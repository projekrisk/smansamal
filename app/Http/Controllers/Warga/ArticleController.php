<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $articles = $user->articles()
            ->with(['category', 'tags'])
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->orderByDesc('id')
            ->paginate(10);

        return view('warga.articles.index', compact('articles'));
    }

    public function create()
    {
        $user = auth()->user();
        if (! $user->is_active) {
            return redirect()->route('dashboard')->with('warning', 'Akun Anda sedang menunggu aktivasi dari admin sebelum dapat menulis karya tulis.');
        }

        $categories = Category::whereIn('type', ['suara_warga', 'both'])->get();

        return view('warga.articles.create', compact('categories'));
    }

    public function store(Request $request, ImageOptimizerService $imageOptimizer)
    {
        $user = auth()->user();
        if (! $user->is_active) {
            abort(403, 'Akun Anda belum diaktifkan.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_mode' => 'nullable|in:normal,full',
            'featured_image_caption' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $imageOptimizer->uploadAndConvertToWebp($request->file('featured_image'), 'articles');
        }

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $article = Article::create([
            'user_id' => $user->id,
            'category_id' => $validated['category_id'],
            'type' => 'suara_warga',
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?: Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'featured_image_mode' => $validated['featured_image_mode'] ?? 'normal',
            'featured_image_caption' => $validated['featured_image_caption'] ?? null,
            'status' => 'pending_review',
        ]);

        Tag::parseAndSync($article, $request->input('tags'));

        return redirect()->route('warga.articles.index')->with('success', 'Karya tulis Anda berhasil dikirim dan sedang menunggu tinjauan moderator sekolah.');
    }

    public function edit(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        $article->load('tags');
        $categories = Category::whereIn('type', ['suara_warga', 'both'])->get();

        return view('warga.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article, ImageOptimizerService $imageOptimizer)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_mode' => 'nullable|in:normal,full',
            'featured_image_caption' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $imageOptimizer->uploadAndConvertToWebp($request->file('featured_image'), 'articles');
        }

        $validated['status'] = 'pending_review';
        $validated['rejection_reason'] = null;

        $article->update($validated);
        Tag::parseAndSync($article, $request->input('tags'));

        return redirect()->route('warga.articles.index')->with('success', 'Karya tulis Anda berhasil diperbarui dan diajukan kembali untuk moderasi.');
    }

    public function destroy(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        $article->delete();

        return redirect()->route('warga.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
