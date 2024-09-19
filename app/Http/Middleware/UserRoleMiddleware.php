<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->personal) {
                $name = $user->personal->name . ' ' . $user->personal->last_name;
                if ($user->personal->role_id == 1) {
                    $rol = 'Administrador';
                    $links = app('adminLinks');
                    $isAdmin = true;
                } elseif ($user->personal->role_id == 2) {
                    $rol = 'Recepcionista';
                    $links = app('receptionistLinks');
                }
                $photo = $user->personal->photo;
            } elseif ($user->student) {
                $name = $user->student->name . ' ' . $user->student->last_name;
                $rol = 'Estudiante';
                $links = app('studentLinks');
                $photo = $user->student->photo;
                $studentId = $user->student->id;
            } elseif ($user->teacher) {
                $name = $user->teacher->name . ' ' . $user->teacher->last_name;
                $rol = 'Profesor';
                $links = app('teacherLinks');
                $photo = 'img/users/teachers/' . $user->teacher->photo;
                $teacherId = $user->teacher->id;
            }

            $request->merge([
                'name' => $name,
                'rol' => $rol,
                'links' => $links,
                'photo' => $photo,
                'teacherId' => $teacherId ?? null,
                'studentId' => $studentId ?? null,
                'isAdmin' => $isAdmin ?? false,
            ]);
        }

        return $next($request);
    }
}
