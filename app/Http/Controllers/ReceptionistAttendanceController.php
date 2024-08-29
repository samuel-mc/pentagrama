<?php

namespace App\Http\Controllers;

use App\Models\AttendanceStudentGroup;
use App\Models\Schedule;
use App\DTO\ScheduleDTO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceptionistAttendanceController extends Controller
{
    public function index()
    {
        $title = 'Inscripción';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('receptionistLinks');
        $currentDayOfWeek = Carbon::now()->dayOfWeek;
        $results = DB::table('schedules as s')
            ->join('groups as g', 'g.id', '=', 's.group_id')
            ->join('courses as c', 'g.course_id', '=', 'g.id')
            ->join('ages as a', 'g.age_id', '=', 'a.id')
            ->join('students_groups as sg', 'sg.id_group', '=', 'g.id')
            ->join('students as s2', 's2.id', '=', 'sg.id_student')
            ->join('teachers as t', 'g.teacher_id', '=', 't.id')
            ->where('s.day_of_week', $currentDayOfWeek)
            ->where('sg.active', 1)
            ->where('s2.active', 1)
            ->select(
                's.start_hour as hour',
                'g.id as course_id',
                DB::raw('CONCAT(g.name, " - ", c.name, " - ", a.name) as course'),
                's2.id as student_id',
                DB::raw('CONCAT(s2.name, " ", s2.last_name) as name'),
                't.id as teacher_id',
                DB::raw('CONCAT(t.name, " ", t.last_name) as teacher'),
                DB::raw('CASE WHEN EXISTS (
                    SELECT 1 
                    FROM attendance_student_groups asg 
                    WHERE asg.student_id = s2.id 
                ) THEN TRUE ELSE FALSE END as asistencia')
            )
            ->orderBy('s.start_hour')
            ->get();

        $studentsToday = $results->map(function ($item) {
            return new ScheduleDTO(
                $item->hour,
                $item->course_id,
                $item->course,
                $item->student_id,
                $item->name,
                $item->teacher_id,
                $item->teacher,
                $item->asistencia
            );
        });

        $studentsWhoAttended = $studentsToday->filter(function ($item) {
            return $item->asistencia;
        });

        $attendenceStudents = $studentsWhoAttended->count() . '/' . $studentsToday->count();

        return view('academia.receptionist.attendance', compact('title', 'name', 'rol', 'links', 'studentsToday', 'attendenceStudents'));
    }

    /**
     * Save the attendance of a student
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function registerAttendance(Request $request)
    {
        $attendance = new AttendanceStudentGroup();
        $attendance->student_id = $request->student_id;
        $attendance->group_id = $request->group_id;
        $attendance->date = Carbon::now();
        $attendance->save();
        return response()->json(['success' => true, 'data' => $attendance]);
    }
}
