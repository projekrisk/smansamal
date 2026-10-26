<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\ImageOptimizerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function __construct(
        protected ImageOptimizerService $imageOptimizer
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('q');
        $status = $request->input('status');

        $query = Announcement::query();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('button_text', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->active();
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $announcements = $query->latest()->paginate(10)->withQueryString();

        $totalCount = Announcement::count();
        $activeCount = Announcement::active()->count();
        $inactiveCount = Announcement::where('is_active', false)->count();

        return view('admin.announcements.index', compact(
            'announcements',
            'search',
            'status',
            'totalCount',
            'activeCount',
            'inactiveCount'
        ));
    }

    public function create(): View
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:popup,floating,both',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);

        $data = [
            'title' => $validated['title'],
            'type' => $validated['type'] ?? 'popup',
            'content' => $validated['content'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'start_at' => $validated['start_at'] ?? null,
            'end_at' => $validated['end_at'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageOptimizer->uploadAndConvertToWebp($request->file('image'), 'announcements');
        }

        $announcement = Announcement::create($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', "Pengumuman \"{$announcement->title}\" berhasil ditambahkan.");
    }

    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|in:popup,floating,both',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'remove_image' => 'nullable|boolean',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'type' => $validated['type'] ?? $announcement->type ?? 'popup',
            'content' => $validated['content'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'start_at' => $validated['start_at'] ?? null,
            'end_at' => $validated['end_at'] ?? null,
        ];

        if ($request->boolean('remove_image')) {
            $updateData['image'] = null;
        }

        if ($request->hasFile('image')) {
            $updateData['image'] = $this->imageOptimizer->uploadAndConvertToWebp($request->file('image'), 'announcements');
        }

        $announcement->update($updateData);

        return redirect()->route('admin.announcements.index')
            ->with('success', "Pengumuman \"{$announcement->title}\" berhasil diperbarui.");
    }

    public function toggleStatus(Announcement $announcement): RedirectResponse
    {
        $announcement->update(['is_active' => ! $announcement->is_active]);

        $statusText = $announcement->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Status pengumuman \"{$announcement->title}\" berhasil {$statusText}.");
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $title = $announcement->title;
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', "Pengumuman \"{$title}\" berhasil dihapus.");
    }
}
