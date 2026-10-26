<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('q');
        $status = $request->input('status');

        $query = Page::query();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'draft') {
            $query->where('is_active', false);
        } elseif ($status === 'system') {
            $query->where('is_system', true);
        }

        $pages = $query->latest()->paginate(10)->withQueryString();

        $totalCount = Page::count();
        $activeCount = Page::where('is_active', true)->count();
        $draftCount = Page::where('is_active', false)->count();
        $systemCount = Page::where('is_system', true)->count();

        return view('admin.pages.index', compact(
            'pages',
            'search',
            'status',
            'totalCount',
            'activeCount',
            'draftCount',
            'systemCount'
        ));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:pages,slug',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $baseSlug = $slug;
        $counter = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $page = Page::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'meta_description' => $validated['meta_description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'is_system' => false,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', "Halaman statis \"{$page->title}\" berhasil dibuat.");
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $slugRule = $page->is_system
            ? 'nullable|string|max:200'
            : 'nullable|string|max:200|unique:pages,slug,'.$page->id;

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => $slugRule,
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'meta_description' => $validated['meta_description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ];

        if (! $page->is_system && ! empty($validated['slug'])) {
            $slug = Str::slug($validated['slug']);
            if ($slug !== $page->slug) {
                $baseSlug = $slug;
                $counter = 1;
                while (Page::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }
                $updateData['slug'] = $slug;
            }
        }

        $page->update($updateData);

        return redirect()->route('admin.pages.index')
            ->with('success', "Halaman statis \"{$page->title}\" berhasil diperbarui.");
    }

    public function toggleStatus(Page $page): RedirectResponse
    {
        $page->update(['is_active' => ! $page->is_active]);

        $statusText = $page->is_active ? 'diaktifkan' : 'dinonaktifkan (draf)';

        return back()->with('success', "Status halaman \"{$page->title}\" berhasil {$statusText}.");
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->is_system) {
            return back()->with('error', 'Halaman sistem bawaan tidak dapat dihapus demi menjaga kestabilan tautan situs.');
        }

        $title = $page->title;
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', "Halaman statis \"{$title}\" berhasil dihapus.");
    }
}
