<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (is_dir(base_path('../public_html'))) {
            $this->app->usePublicPath(base_path('../public_html'));
        }
    }

    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url): MailMessage {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email - SMAN 1 Malingping')
                ->view('emails.verify-email', [
                    'user' => $notifiable,
                    'url' => $url,
                ]);
        });
    }
}
