<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // 1. Definisikan aturan main untuk gerbang Admin
        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });

        // 2. Definisikan aturan main untuk gerbang Kasir
        Gate::define('access-kasir', function (User $user) {
            return $user->role === 'kasir';
        });
    }
}
