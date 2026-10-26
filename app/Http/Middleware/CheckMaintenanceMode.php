<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Determine if maintenance mode is enabled via .env or database settings.
     */
    public static function isMaintenanceActive(): bool
    {
        $envEnabled = (bool) config('app.maintenance.enabled');
        $dbEnabled = Setting::getBool('maintenance_enabled', false);

        return $envEnabled || $dbEnabled;
    }

    /**
     * Retrieve maintenance page configuration.
     *
     * @return array{title: string, message: string, end_time: ?string, secret: ?string}
     */
    public static function getMaintenanceData(): array
    {
        $defaultTitle = 'Situs Sedang Dalam Pemeliharaan';
        $defaultMessage = 'Kami sedang melakukan pemeliharaan rutin dan peningkatan performa sistem demi kenyamanan Anda. Silakan kembali dalam beberapa saat.';

        $title = Setting::get('maintenance_title');
        if (empty($title)) {
            $title = (string) config('app.maintenance.title', $defaultTitle);
        }

        $message = Setting::get('maintenance_message');
        if (empty($message)) {
            $message = (string) config('app.maintenance.message', $defaultMessage);
        }

        $endTime = Setting::get('maintenance_end_time');
        if (empty($endTime)) {
            $endTime = config('app.maintenance.end_time');
        }

        $secret = Setting::get('maintenance_secret');
        if (empty($secret)) {
            $secret = config('app.maintenance.secret');
        }

        return [
            'title' => $title,
            'message' => $message,
            'end_time' => $endTime ? (string) $endTime : null,
            'secret' => $secret ? (string) $secret : null,
        ];
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (! static::isMaintenanceActive()) {
            return $next($request);
        }

        // Exempt critical system paths (admin panel, auth, health check, favicon)
        if ($this->isExemptPath($request)) {
            return $next($request);
        }

        // Exempt authenticated administrators
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        // Exempt via secret bypass key (query param ?bypass=... or cookie)
        $data = static::getMaintenanceData();
        $secret = $data['secret'];

        if (! empty($secret)) {
            if ($request->query('bypass') === $secret) {
                cookie()->queue(cookie('maintenance_bypass', $secret, 120, null, null, false, false));

                return $next($request);
            }

            if ($request->cookie('maintenance_bypass') === $secret) {
                return $next($request);
            }
        }

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => $data['title'],
                'detail' => $data['message'],
                'estimated_completion' => $data['end_time'],
                'status' => 503,
            ], 503);
        }

        return response()
            ->view('maintenance', $data, 503)
            ->header('Retry-After', '3600');
    }

    protected function isExemptPath(Request $request): bool
    {
        return $request->is('admin*')
            || $request->is('login')
            || $request->is('logout')
            || $request->is('up')
            || $request->is('icon.png');
    }
}
