<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('adminLinks', function () {
            return [
                (object) ['url' => '/admin', 'name' => 'Dashboard', 'icon' => 'home.png'],
                (object) ['url' => '/admin/profesores', 'name' => 'Profesores', 'icon' => 'profesor.png'],
                (object) ['url' => '/admin/info-adicional', 'name' => 'Información adicional', 'icon' => 'info.png'],
            ];
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
