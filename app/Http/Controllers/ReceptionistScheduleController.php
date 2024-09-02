<?php

namespace App\Http\Controllers;

use App\Models\Age;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ReceptionistScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Inscripción';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('receptionistLinks');
        $schedule = Schedule::where('active', 1)->get();
        $hours = $schedule->map(function ($item) {
            return $item->start_hour;
        })->unique()->sort();
        $days = ['', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        $scheduleReceptionist = [];
//        $scheduleReceptionist[] = $days;

        for($i = 1; $i < count($hours) + 1 ;$i++) {
            $scheduleReceptionist[$i] = [];
            $scheduleReceptionist[$i][] = $hours[$i - 1];
            for ($j = 1; $j < count($days); $j++) {
                $courses = $schedule->filter(function ($item) use ($hours, $i, $j) {
                    return $item->start_hour == $hours[$i - 1] && $item->day_of_week == $j;
                });
                $scheduleReceptionist[$i][$j] = $courses->map(function ($item) {
                    return $item->group->course->name . ' (' . $item->group->age->description . ')';
                })->implode(', ');
            }
        }

        $ages = Age::where('active', 1)->get();

//        dd($scheduleReceptionist);
        return view('academia.receptionist.schedule', compact('scheduleReceptionist', 'days', 'title', 'name', 'rol', 'links', 'ages'));
    }

}
