<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request, ImageOptimizerService $imageOptimizer)
    {
        if (auth()->check() && Testimonial::where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Anda sudah pernah membuat testimoni. Setiap alumni hanya dapat membuat 1 kali testimoni.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'graduation_year' => 'required|numeric|min:1970|max:2035',
            'current_role' => 'required|string|max:150',
            'content' => 'required|string|max:300',
            'avatar' => 'nullable|image|max:3072',
        ], [
            'content.max' => 'Testimoni maksimal berisi 300 karakter agar tetap padat dan ringkas.',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $imageOptimizer->uploadAndConvertToWebp($request->file('avatar'), 'avatars');
        }

        Testimonial::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'role_subtitle' => "Alumni {$validated['graduation_year']} • {$validated['current_role']}",
            'content' => '"'.trim($validated['content'], '"').'"',
            'avatar' => $avatarPath,
            'is_approved' => true,
        ]);

        return back()->with('success', 'Terima kasih! Testimoni Anda berhasil dikirim.');
    }
}
