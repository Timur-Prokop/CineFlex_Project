<?php

namespace App\Providers;

use App\Models\Film;
use App\Policies\FilmPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Policies\EmployeePolicy;

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
        Gate::policy(User::class, EmployeePolicy::class);

        Gate::policy(Film::class, FilmPolicy::class);

        Gate::define('can-access-manager-area', function (User $user) {
            return $user->isManager();
        });

        Gate::define('can-see-workers', function (User $user) {
            return $user->isManager() || $user->isWorker();
        });


        Gate::define('can-access-worker-area', function (User $user) {
            return $user->isWorker();
        });

        Gate::define('can-access-client-area', function (User $user) {
            return $user->isClient();
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verificeer je Cineflex-account')
                ->greeting('Welkom bij Cineflex!')
                ->line('Bedankt voor het aanmaken van je account.')
                ->line('Klik op de knop hieronder om je e-mailadres te verifiëren.')
                ->action('E-mailadres verifiëren', $url)
                ->line('Als je dit account niet hebt aangemaakt, kun je deze e-mail negeren.');
        });
    }
}
