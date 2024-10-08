<?php

namespace App\Http\Controllers;

use App\Models\AttendanceStudentGroup;
use App\Models\AttendanceTeacherGroup;
use App\Models\Schedule;
use App\DTO\ScheduleDTO;
use App\Models\Teacher;
use App\Models\TeacherSubstitute;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceptionistAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Inscripción';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $currentDay = Carbon::now()->format('Y-m-d');
        $currentDayOfWeek = Carbon::now()->dayOfWeek;

        $resultsStudents = DB::table('schedules as s')
            ->join('groups as g', 'g.id', '=', 's.group_id')
            ->join('courses as c', 'g.course_id', '=', 'c.id')
            ->join('students as s2', 's2.id', '=', 'g.student_id')
            ->join('teachers as t', 'g.teacher_id', '=', 't.id')
            ->join('time_slots as ts', 's.time_slot_id', '=', 'ts.id')
            ->where('s.day_of_week', $currentDayOfWeek)
            ->where('s2.active', 1)
            ->select(
                DB::raw('CONCAT(LPAD(ts.hour, 2, "0"), ":", LPAD(ts.minute, 2, "0")) as hour'),
                'g.id as course_id',
                DB::raw('CONCAT(c.name) as course'),
                's2.id as student_id',
                DB::raw('CONCAT(s2.name, " ", s2.last_name) as name'),
                't.id as teacher_id',
                DB::raw('CONCAT(t.name, " ", t.last_name) as teacher'),
                DB::raw('CASE WHEN EXISTS (
                    SELECT 1
                    FROM attendance_student_groups asg
                    WHERE asg.student_id = s2.id
                    AND asg.group_id = g.id
                    AND asg.date = "' . $currentDay . '"
                ) THEN TRUE ELSE FALSE END as asistencia'),
                DB::raw('CASE WHEN EXISTS (
                    SELECT 1
                    FROM teacher_substitutes ts
                    WHERE ts.teacher_id = t.id
                    AND ts.group_id = g.id
                    AND ts.date = "' . $currentDay . '"
                ) THEN (
        	        SELECT CONCAT(t.name, " ", t.last_name) FROM teachers t2 WHERE t2.id = t.id) ELSE null END as substitute')
            )
            ->orderBy('ts.hour')
            ->orderBy('ts.minute')
            ->get();

        $resultsTeaches = DB::table('schedules as s')
            ->join('groups as g', 'g.id', '=', 's.group_id')
            ->join('courses as c', 'g.course_id', '=', 'c.id')
            ->join('teachers as t', 'g.teacher_id', '=', 't.id')
            ->join('time_slots as ts', 's.time_slot_id', '=', 'ts.id')
            ->where('s.day_of_week', $currentDayOfWeek)
            ->where('t.active', 1)
            ->select(
                DB::raw('CONCAT(LPAD(ts.hour, 2, "0"), ":", LPAD(ts.minute, 2, "0")) as hour'),
                'g.id as course_id',
                DB::raw('CONCAT(c.name) as course'),
                't.id as teacher_id',
                DB::raw('CONCAT(t.name, " ", t.last_name) as teacher'),
                DB::raw('CASE WHEN EXISTS (
                    SELECT 1
                    FROM attendance_teacher_groups asg
                    WHERE asg.teacher_id = t.id
                    AND asg.date = "' . $currentDay . '"
                ) THEN TRUE ELSE FALSE END as asistencia'),
                DB::raw('CASE WHEN EXISTS (
                    SELECT 1
                    FROM teacher_substitutes ts
                    WHERE ts.teacher_id = t.id
                    AND ts.group_id = g.id
                    AND ts.date = "' . $currentDay . '"
                ) THEN (
        	        SELECT CONCAT(t.name, " ", t.last_name) FROM teachers t2 WHERE t2.id = t.id) ELSE null END as substitute'))
            ->orderBy('ts.hour')
            ->get();

        $studentsToday = $resultsStudents->map(function ($item) {
            return new ScheduleDTO(
                $item->hour,
                $item->course_id,
                $item->course,
                $item->student_id,
                $item->name,
                $item->teacher_id,
                $item->teacher,
                $item->asistencia,
                $item->substitute
            );
        });

        $studentsWhoAttended = $studentsToday->filter(function ($item) {
            return $item->asistencia;
        });

        $attendenceStudents = $studentsWhoAttended->count() . '/' . $studentsToday->count();

        $teachersWhoAttended = $resultsTeaches->filter(function ($item) {
            return $item->asistencia;
        });
        $attendenceTeachers = $teachersWhoAttended->count() . '/' . $resultsTeaches->count();

        $teachersSubstitute = Teacher::where('active', 1)->get();

        return view('academia.receptionist.attendance', compact('title', 'name', 'rol', 'links', 'studentsToday', 'attendenceStudents', 'resultsTeaches', 'attendenceTeachers', 'teachersSubstitute','photo'));
    }

    /**
     * Save the attendance of a student
     * @param Request $request
     * @return
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

    /**
     * Add a substitute teacher
     * @param Request $request
     * @return JsonResponse
     */
    public function addSubstituteTeacher(Request $request): JsonResponse
    {
        $substitute = new TeacherSubstitute();
        $substitute->teacher_id = $request->teacher_id;
        $substitute->substitute_id = $request->substitute_id;
        $substitute->group_id = $request->group_id;
        $substitute->date = Carbon::now();
        $substitute->save();
        return response()->json(['success' => true, 'data' => $substitute]);

    }

    /**
     * Register the attendance of a teacher
     * @param Request $request
     * @return JsonResponse
     */
    public function registerTeacherAttendance(Request $request): JsonResponse
    {
        $attendance = new AttendanceTeacherGroup();
        $attendance->teacher_id = $request->teacher_id;
        $attendance->group_id = $request->group_id;
        $attendance->date = Carbon::now();
        $attendance->save();
        return response()->json(['success' => true, 'data' => $attendance]);
    }
}
