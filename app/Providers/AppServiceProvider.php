<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        Gate::define('admin', function () {
            return Auth::user()->role->name === 'admin';
        });
        Gate::define('cabangOwner', function ($user, $cabang) {
            return $user->role->name === 'admin' || $user->profile->cabang_id === $cabang->id;
        });
    }
}
