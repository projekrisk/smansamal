<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Notifications\TestimonialStatusNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Testimonial::with('user');

        if ($status === 'approved') {
            $query->where('is_approved', true);
        } elseif ($status === 'pending') {
            $query->where('is_approved', false)->where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhereNull('status');
            });
        } elseif ($status === 'rejected') {
            $query->where('is_approved', false)->where('status', 'rejected');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('role_subtitle', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('rejection_reason', 'like', "%{$search}%");
            });
        }

        $totalCount = Testimonial::count();
        $approvedCount = Testimonial::where('is_approved', true)->count();
        $pendingCount = Testimonial::where('is_approved', false)
            ->where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhereNull('status');
            })->count();
        $rejectedCount = Testimonial::where('is_approved', false)
            ->where('status', 'rejected')
            ->count();

        $testimonials = $query->latest('id')->paginate(10)->withQueryString();

        return view('admin.testimonials.index', compact(
            'testimonials',
            'status',
            'search',
            'totalCount',
            'approvedCount',
            'pendingCount',
            'rejectedCount'
        ));
    }

    public function toggleApproval(Testimonial $testimonial): RedirectResponse
    {
        $newApproval = ! $testimonial->is_approved;

        $testimonial->update([
            'is_approved' => $newApproval,
            'status' => $newApproval ? 'approved' : 'pending',
            'rejection_reason' => $newApproval ? null : $testimonial->rejection_reason,
        ]);

        if ($newApproval && $testimonial->user) {
            $testimonial->user->notify(new TestimonialStatusNotification($testimonial, 'approved'));
        }

        $message = $newApproval
            ? "Testimoni dari {$testimonial->name} berhasil disetujui dan kini ditayangkan di beranda."
            : "Testimoni dari {$testimonial->name} ditarik dari tayangan beranda.";

        return back()->with('success', $message);
    }

    public function reject(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $testimonial->update([
            'is_approved' => false,
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        if ($testimonial->user) {
            $testimonial->user->notify(new TestimonialStatusNotification($testimonial, 'rejected'));
        }

        return back()->with('success', "Testimoni dari {$testimonial->name} ditolak dengan catatan untuk direvisi.");
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $name = $testimonial->name;
        $testimonial->delete();

        return back()->with('success', "Testimoni dari {$name} berhasil dihapus.");
    }
}
