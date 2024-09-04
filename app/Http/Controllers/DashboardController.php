<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Group;

class DashboardController extends Controller
{
    /**
     * Display the teacher dashboard.
     */
    public function displayTeacherDashboard()
    {
        $title = 'Dashboard';
        $name = 'Elias Cordova';
        $rol = 'Teacher';
        $links = app('teacherLinks');

        Carbon::setLocale('es');
        $fecha = Carbon::now();
        $dayName = $fecha->isoFormat('dddd');
        $dayName = ucfirst($dayName);

//        dd($dayName);
        $groups = Group::where('teacher_id', 1)->get();

        $schedule = $groups->map(function ($item) {
            return $item->schedules;
        });

        dd($schedule);

        $hours = $schedule->map(function ($item) {
            return $item->start_hour;
        })->unique()->sort();
        $days = ['', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
//        dd($groups);
        return view('academia.dashboard.teacher', compact('title', 'name', 'rol', 'links', 'dayName', 'groups'));

    }
}
