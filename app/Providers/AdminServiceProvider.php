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
                (object) ['url' => '/admin/dashboard-admin', 'name' => 'Dashboard', 'icon' => 'home.png'],
                (object) ['url' => '/admin/inscripcion', 'name' => 'Incripción', 'icon' => 'inscripcion.png'],
                (object) ['url' => '/admin/estudiantes', 'name' => 'Estudiantes', 'icon' => 'students.png'],
                (object) ['url' => '/admin/profesores', 'name' => 'Profesores', 'icon' => 'profesor.png'],
                (object) ['url' => '/admin/personal', 'name' => 'Personal', 'icon' => 'personal.png'],
                (object) ['url' => '/admin/cuentas', 'name' => 'Cuentas', 'icon' => 'acount.png'],
                (object) ['url' => '/admin/horarios', 'name' => 'Horarios', 'icon' => 'schedule.png'],
                (object) ['url' => '/admin/asistencia', 'name' => 'Asistencia', 'icon' => 'attendence.png'],
                (object) ['url' => '/admin/usuarios', 'name' => 'Usuarios', 'icon' => 'users.png'],
                (object) ['url' => '/admin/info-adicional', 'name' => 'Información adicional', 'icon' => 'info.png'],
                (object) ['url' => '/logout', 'name' => 'Cerrar sesión', 'icon' => 'logout.png'],
            ];
        });

        $this->app->singleton('receptionistLinks', function() {
            return [
                (object) ['url' => '/admin/dashboard-recepcion', 'name' => 'Dashboard', 'icon' => 'home.png'],
//                (object) ['url' => '/admin/estudiantes', 'name' => 'Estudiantes', 'icon' => 'students.png'],
                (object) ['url' => '/admin/recepcionista/registrar-pago', 'name' => 'Pagos', 'icon' => 'addPayment.png'],
                (object) ['url' => '/admin/asistencia', 'name' => 'Asistencia', 'icon' => 'attendence.png'],
                (object) ['url' => '/admin/inscripcion', 'name' => 'Incripción', 'icon' => 'inscripcion.png'],
                (object) ['url' => '/admin/horarios', 'name' => 'Horarios', 'icon' => 'schedule.png'],
                (object) ['url' => '/admin/cuentas', 'name' => 'Cuentas', 'icon' => 'acount.png'],
                (object) ['url' => '/logout', 'name' => 'Cerrar sesión', 'icon' => 'logout.png'],

            ];
        });

        $this->app->singleton('teacherLinks', function() {
            return [
                (object) ['url' => '/admin/dashboard-profesores', 'name' => 'Dashboard', 'icon' => 'home.png'],
                (object) ['url' => '/admin/profesores/horarios-disponibles', 'name' => 'Horarios', 'icon' => 'schedule.png'], // Ruta a la pantalla que muestra los horarios y cursos disponibles
                (object) ['url' => '/admin/profesores/mis-estudiantes', 'name' => 'Estudiantes', 'icon' => 'students.png'], // Ruta a la pantalla que muestra los cursos asignados al profesor
                (object) ['url' => '/admin/profesores/bitacora', 'name' => 'Bitácora', 'icon' => 'log.png'], // Ruta a la pantalla que muestra la bitácora del profesor
                (object) ['url' => '/logout', 'name' => 'Cerrar sesión', 'icon' => 'logout.png'],
           ];
        });

        $this->app->singleton('studentLinks', function() {
            return [
            (object) ['url' => '/admin/dashboard-estudiantes', 'name' => 'Dashboard', 'icon' => 'home.png'],
                (object) ['url' => '/admin/estudiantes/mi-bitacora/consulta', 'name' => 'Bitácora', 'icon' => 'log.png'],
                (object) ['url' => '/admin/estudiantes/mis-pagos/consulta', 'name' => 'Registrar pago', 'icon' => 'addPayment.png'],
                (object) ['url' => '/logout', 'name' => 'Cerrar sesión', 'icon' => 'logout.png'],
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
