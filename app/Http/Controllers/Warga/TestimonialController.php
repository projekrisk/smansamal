<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\ImageOptimizerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $testimonials = $user->testimonials()->latest()->paginate(10);

        return view('warga.testimonials.index', compact('testimonials'));
    }

    public function create(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->testimonials()->exists()) {
            return redirect()->route('warga.testimonials.index')
                ->with('warning', 'Anda sudah pernah membuat testimoni. Setiap alumni hanya dapat membuat 1 kali testimoni.');
        }

        return view('warga.testimonials.create', compact('user'));
    }

    public function store(Request $request, ImageOptimizerService $imageOptimizer): RedirectResponse
    {
        $user = auth()->user();

        if ($user->testimonials()->exists()) {
            return redirect()->route('warga.testimonials.index')
                ->with('error', 'Anda sudah pernah membuat testimoni. Setiap alumni hanya dapat membuat 1 kali testimoni.');
        }

        $validated = $request->validate([
            'role_subtitle' => 'required|string|max:100',
            'content' => 'required|string|max:300',
            'avatar' => 'nullable|image|max:3072',
        ], [
            'content.max' => 'Testimoni maksimal berisi 300 karakter agar tetap padat dan ringkas.',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $imageOptimizer->uploadAndConvertToWebp($request->file('avatar'), 'testimonials');
        } elseif ($user->avatar) {
            $avatarPath = $user->avatar;
        }

        Testimonial::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'role_subtitle' => $validated['role_subtitle'],
            'content' => $validated['content'],
            'avatar' => $avatarPath,
            'is_approved' => false,
            'status' => 'pending',
        ]);

        return redirect()->route('warga.testimonials.index')->with('success', 'Testimoni Anda berhasil dikirim dan terkunci untuk ditinjau oleh redaksi.');
    }

    public function edit(Testimonial $testimonial): RedirectResponse
    {
        return redirect()->route('warga.testimonials.index')
            ->with('warning', 'Testimoni yang sudah dikirimkan telah terkunci dan tidak dapat diedit kembali.');
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        return redirect()->route('warga.testimonials.index')
            ->with('error', 'Testimoni yang sudah dibuat telah terkunci dan tidak dapat diedit.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        return redirect()->route('warga.testimonials.index')
            ->with('error', 'Testimoni yang sudah dibuat telah terkunci dan tidak dapat dihapus.');
    }
}
