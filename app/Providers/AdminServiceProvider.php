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
                (object) ['url' => '/admin/inscripcion', 'name' => 'Incripción', 'icon' => 'inscripcion.png'],
                (object) ['url' => '/admin/estudiantes', 'name' => 'Estudiantes', 'icon' => 'students.png'],
                (object) ['url' => '/admin/profesores', 'name' => 'Profesores', 'icon' => 'profesor.png'],
                (object) ['url' => '/admin/grupos', 'name' => 'Grupos', 'icon' => 'groups.png'],
                (object) ['url' => '/admin/personal', 'name' => 'Personal', 'icon' => 'personal.png'],
                (object) ['url' => '/admin/usuarios', 'name' => 'Usuarios', 'icon' => 'users.png'],
                (object) ['url' => '/admin/cuentas', 'name' => 'Cuentas', 'icon' => 'acount.png'],
                (object) ['url' => '/admin/info-adicional', 'name' => 'Información adicional', 'icon' => 'info.png'],
            ];
        });

        $this->app->singleton('receptionistLinks', function() {
            return [
                (object) ['url' => '/admin', 'name' => 'Dashboard', 'icon' => 'home.png'],
                (object) ['url' => '/admin/estudiantes', 'name' => 'Estudiantes', 'icon' => 'students.png'],
                (object) ['url' => '/admin/asistencia', 'name' => 'Asistencia', 'icon' => 'attendence.png'],
                (object) ['url' => '/admin/inscripcion', 'name' => 'Incripción', 'icon' => 'inscripcion.png'],               
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
