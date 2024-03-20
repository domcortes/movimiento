<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->register();
        Gate::define('superadmin-menu', function ($user) {
            return $user->role === 'superadmin' ? true : false;
        });

        Gate::define('admin-menu', function ($user) {
            return $user->role === 'admin' ? true : false;
        });

        Gate::define('profesor-menu', function ($user) {
            return $user->role === 'profesor' ? true : false;
        });

        Gate::define('alumno-menu', function ($user) {
            return $user->role === 'alumno' ? true : false;
        });
    }
}
