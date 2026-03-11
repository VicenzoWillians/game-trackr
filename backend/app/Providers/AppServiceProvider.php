<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::createUrlUsing(function (object $notifiable) {
            $id = $notifiable->getKey();
            $hash = sha1($notifiable->getEmailForVerification());
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
            
            return "{$frontendUrl}/auth/verify?id={$id}&hash={$hash}";
        });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('GameTrackr - Verifique o seu e-mail')
                ->view('emails.verify', [
                    'url' => $url,
                    'name' => $notifiable->name
                ]);
        });

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
            // O Vue precisa do token E do e-mail na URL para conseguir trocar a senha depois
            return "{$frontendUrl}/auth/reset-password?token={$token}&email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
