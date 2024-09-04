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
                $rol = 'Personal';
                $links = app('adminLinks');
                $photo = $user->personal->photo;
            } elseif ($user->student) {
                $name = $user->student->name . ' ' . $user->student->last_name;
                $rol = 'Estudiante';
                $links = app('studentLinks');
                $photo = $user->student->photo;
            } elseif ($user->teacher) {
                $name = $user->teacher->name . ' ' . $user->teacher->last_name;
                $rol = 'Profesor';
                $links = app('teacherLinks');
                $photo = 'img/users/teachers/' . $user->teacher->photo;
            }

            $request->merge([
                'name' => $name,
                'rol' => $rol,
                'links' => $links,
                'photo' => $photo,
            ]);
        }

        return $next($request);
    }
}
