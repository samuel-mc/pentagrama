<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class EstudentsByTeacherController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Estudiantes: ' . $request->name;
        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;
        $teacherId = $request->teacherId;

        $days = [
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sábado',
            'Domingo',
        ];

        $groups = Group::where('teacher_id', $teacherId)->get();
        $groups = $groups->map(function ($group) use ($days) {
            return (object) [
                'id' => $group->id,
                'student' => $group->student->name . ' ' . $group->student->last_name,
                'course' => $group->course->name,
                'schedule' => $group->schedules->map(function ($schedule) use ($days) {
                    return (object) [
                        'day' => $days[$schedule->day_of_week - 1] ?? '',
                        'hour' => $this->addZero($schedule->timeSlot->hour) . ':' . $this->addZero($schedule->timeSlot->minute)
                    ];
                })
            ];
        });

        //sort by student
        $groups = $groups->sortBy('student');

//        dd($groups);
        return view('academia.teacher.my-students', compact('title', 'name', 'rol', 'links', 'photo', 'groups'));
    }

    private function addZero(string $time): string
    {
        //add 0 if the number is less than 10
        return $time < 10 ? '0' . $time : $time;
    }
}
