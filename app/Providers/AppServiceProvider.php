<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
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
        Gate::define('access-manager-area', function (User $user) {
            return $user->isManager();
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verifieer je Cineflex-account')
                ->greeting('Welkom bij Cineflex!')
                ->line('Bedankt voor het aanmaken van je account.')
                ->line('Klik op de knop hieronder om je e-mailadres te verifiëren.')
                ->action('E-mailadres verifiëren', $url)
                ->line('Als je dit account niet hebt aangemaakt, kun je deze e-mail negeren.');
        });
    }
}
