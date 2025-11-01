<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('is-administrator', function (User $user) {
            return $user->role->id == 1;
        });

        Gate::define('is-member', function (User $user) {
            return $user->role->id == 2;
        });
    }
}
