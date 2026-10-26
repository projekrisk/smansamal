<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MaintenanceSettingController extends Controller
{
    /**
     * Display the maintenance mode settings page.
     */
    public function index(): View
    {
        $envEnabled = (bool) config('app.maintenance.enabled');
        $dbEnabled = Setting::getBool('maintenance_enabled', false);
        $isCurrentlyActive = $envEnabled || $dbEnabled;

        $settings = [
            'maintenance_enabled' => $dbEnabled,
            'env_maintenance_enabled' => $envEnabled,
            'is_currently_active' => $isCurrentlyActive,
            'maintenance_title' => Setting::get('maintenance_title', config('app.maintenance.title', 'Situs Sedang Dalam Pemeliharaan')),
            'maintenance_message' => Setting::get('maintenance_message', config('app.maintenance.message', 'Kami sedang melakukan pemeliharaan rutin dan peningkatan performa sistem demi kenyamanan Anda. Silakan kembali dalam beberapa saat.')),
            'maintenance_end_time' => Setting::get('maintenance_end_time', config('app.maintenance.end_time', '')),
            'maintenance_secret' => Setting::get('maintenance_secret', config('app.maintenance.secret', '')),
        ];

        return view('admin.maintenance.index', compact('settings'));
    }

    /**
     * Update the maintenance mode settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'maintenance_enabled' => ['nullable', 'boolean'],
            'maintenance_title' => ['nullable', 'string', 'max:255'],
            'maintenance_message' => ['nullable', 'string', 'max:3000'],
            'maintenance_end_time' => ['nullable', 'string', 'max:100'],
            'maintenance_secret' => ['nullable', 'string', 'max:100'],
        ]);

        Setting::set('maintenance_enabled', $request->has('maintenance_enabled') ? '1' : '0');
        Setting::set('maintenance_title', $validated['maintenance_title'] ?? null);
        Setting::set('maintenance_message', $validated['maintenance_message'] ?? null);
        Setting::set('maintenance_end_time', $validated['maintenance_end_time'] ?? null);
        Setting::set('maintenance_secret', $validated['maintenance_secret'] ?? null);

        $statusMsg = $request->has('maintenance_enabled')
            ? 'Mode pemeliharaan diaktifkan.'
            : 'Mode pemeliharaan dinonaktifkan.';

        return redirect()
            ->route('admin.maintenance.index')
            ->with('success', "Pengaturan berhasil disimpan. {$statusMsg}");
    }

    /**
     * Preview the maintenance page without activating it globally.
     */
    public function preview(): View
    {
        $data = CheckMaintenanceMode::getMaintenanceData();

        return view('maintenance', $data);
    }

    /**
     * Display the public maintenance page (/pemeliharaan).
     */
    public function showPublicMaintenance(): Response|RedirectResponse
    {
        if (! CheckMaintenanceMode::isMaintenanceActive() && ! (auth()->check() && auth()->user()->isAdmin())) {
            return redirect()->route('home');
        }

        $data = CheckMaintenanceMode::getMaintenanceData();

        return response()
            ->view('maintenance', $data, 503)
            ->header('Retry-After', '3600');
    }
}
