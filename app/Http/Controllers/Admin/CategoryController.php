<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->latest()->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'type' => 'required|in:jurnal,suara_warga,both',
            'description' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:30',
        ]);

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'] ?? '#2A5C43',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'category' => $category,
                'message' => 'Kategori berhasil ditambahkan.',
            ]);
        }

        return back()->with('success', "Kategori \"{$category->name}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$category->id,
            'slug' => 'nullable|string|max:100|unique:categories,slug,'.$category->id,
            'type' => 'required|in:jurnal,suara_warga,both',
            'description' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:30',
        ]);

        $baseSlug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'] ?? '#2A5C43',
        ]);

        return back()->with('success', "Kategori \"{$category->name}\" berhasil diperbarui.");
    }

    public function destroy(Category $category)
    {
        $name = $category->name;

        $category->articles()->update(['category_id' => null]);

        $category->delete();

        return back()->with('success', "Kategori \"{$name}\" berhasil dihapus.");
    }
}
