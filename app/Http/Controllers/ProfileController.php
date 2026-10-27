<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImageOptimizerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function showPublic(string $username, Request $request): View|RedirectResponse|JsonResponse
    {

        if (is_numeric($username)) {
            $userById = User::find($username);
            if ($userById && $userById->username) {
                return redirect()->route('warga.profile', $userById->username, 301);
            }
        }

        $user = User::withCount(['articles' => function ($q) {
            $q->published();
        }])->where('username', $username)->firstOrFail();

        $articles = $user->articles()
            ->with('category')
            ->withCount('comments')
            ->published()
            ->latest('published_at')
            ->paginate(6);

        if ($request->ajax() || $request->has('load_more')) {
            $html = '';
            foreach ($articles as $article) {
                $html .= view('profile.partials.article-card', [
                    'article' => $article,
                    'user' => $user,
                ])->render();
            }

            return response()->json([
                'html' => $html,
                'next_page_url' => $articles->nextPageUrl(),
                'has_more' => $articles->hasMorePages(),
                'total' => $articles->total(),
            ]);
        }

        $totalLikes = (int) $user->articles()->published()->sum('likes_count');
        $totalViews = (int) $user->articles()->published()->sum('views_count');
        $followersCount = $user->followers()->count();

        $currentUser = auth()->user();
        $isFollowing = $currentUser ? $user->isFollowedBy($currentUser) : false;

        return view('profile.profil-warga', compact(
            'user',
            'articles',
            'totalLikes',
            'totalViews',
            'followersCount',
            'isFollowing'
        ));
    }

    public function toggleFollow(string $username, Request $request)
    {
        $currentUser = auth()->user();
        $targetUser = User::where('username', $username)->firstOrFail();

        if ($currentUser->id === $targetUser->id) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat mengikuti akun Anda sendiri.',
                ], 422);
            }

            return back()->with('error', 'Anda tidak dapat mengikuti akun Anda sendiri.');
        }

        $isFollowing = $targetUser->isFollowedBy($currentUser);

        if ($isFollowing) {
            $targetUser->followers()->detach($currentUser->id);
            $following = false;
            $message = "Berhenti mengikuti {$targetUser->name}.";
        } else {
            $targetUser->followers()->attach($currentUser->id);
            $following = true;
            $message = "Anda sekarang mengikuti {$targetUser->name}!";
        }

        $followersCount = $targetUser->followers()->count();
        $formattedCount = $followersCount >= 1000
            ? round($followersCount / 1000, 1).'k'
            : (string) $followersCount;

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'following' => $following,
                'followers_count' => $followersCount,
                'followers_formatted' => $formattedCount,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function markNotificationAsRead(string $id, Request $request)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        $redirectUrl = $notification->data['target_url'] ?? $notification->data['article_url'] ?? route('dashboard');

        return redirect($redirectUrl);
    }

    public function markAllNotificationsAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }

    public function edit(Request $request): View
    {
        $user = $request->user();

        $totalArticles = $user->articles()->count();
        $totalLikes = (int) $user->articles()->published()->sum('likes_count');
        $totalViews = (int) $user->articles()->published()->sum('views_count');

        return view('profile.edit', [
            'user' => $user,
            'totalArticles' => $totalArticles,
            'totalLikes' => $totalLikes,
            'totalViews' => $totalViews,
        ]);
    }

    public function update(Request $request, ImageOptimizerService $imageOptimizer): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', 'alpha_dash', 'unique:users,username,'.$user->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:4096'],
            'nisn' => ['nullable', 'string', 'max:20'],
            'kelas' => ['nullable', 'string', 'max:30'],
            'nip' => ['nullable', 'string', 'max:30'],
            'mata_pelajaran' => ['nullable', 'string', 'max:100'],
            'tahun_lulus' => ['nullable', 'string', 'max:10'],
            'pekerjaan_kampus' => ['nullable', 'string', 'max:200'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.unique' => 'Peringatan: Username (Slug) ":input" sudah digunakan oleh pengguna lain. Silakan pilih username yang berbeda.',
            'username.alpha_dash' => 'Username hanya boleh memuat huruf, angka, tanda strip (-), dan garis bawah (_).',
            'username.max' => 'Username tidak boleh lebih dari 50 karakter.',
            'avatar.image' => 'Foto profil harus berupa file gambar.',
            'avatar.max' => 'Ukuran file foto profil maksimal 4MB.',
            'bio.max' => 'Bio profil maksimal 1000 karakter.',
        ]);

        if (empty($validated['username'])) {
            $validated['username'] = $user->username;
        }

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $imageOptimizer->uploadAndConvertToWebp($request->file('avatar'), 'avatars');
        }

        unset($validated['email']);

        $user->fill($validated);

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
