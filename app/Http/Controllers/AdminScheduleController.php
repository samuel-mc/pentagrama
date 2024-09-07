<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Student;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminScheduleController extends Controller
{

    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function goTo()
    {
        return redirect()->route('admin.horarios', ['studentId' => "1"]);
    }

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
//        dd($request->all());
        $title = 'Horario';
        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $selectedStudent = $request->studentId;

        $schedule = $this->scheduleService->getScheduleAdmin();
        $days = $this->scheduleService->getScheduleDays();

        return view('academia.admin.admin-schedules', compact('title', 'name', 'rol', 'links', 'photo', 'schedule', 'days', 'selectedStudent'));
    }

    public function addSchedule(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $title = 'Registrar Horario';
        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $students = Student::where('active', 1)->orderBy('name', 'ASC')->get();
        $courses = Course::where('active', 1)->orderBy('name', 'ASC')->get();
        $days = $this->scheduleService->getSheduleDaysAsObject();

        $selectedDay = $request->day + 1;
        $selectedHour = $request->hour;
        $selectedStudent = $request->selectedStudent;

//        dd($selectedDay, $selectedHour);

        return view('academia.admin.add-schedule', compact('title', 'name', 'rol', 'links', 'photo', 'students', 'courses', 'days', 'selectedDay', 'selectedHour', 'selectedStudent'));
    }

    public function saveSchedule(Request $request)
    {
        //Save the group
        DB::transaction(function () use ($request) {
            $group = Group::where('student_id', $request->student)->where('course_id', $request->course)->where('teacher_id', $request->teacher)->first();
            if (!$group) {
                $group = new Group();
                $group->teacher_id = $request->teacher;
                $group->course_id = $request->course;
                $group->student_id = $request->student;
                $group->monthly_payment = $request->monthly_payment;
                $group->monthly_payment_date = $request->monthly_payment_date;
                $group->save();
            }

            $schedule = new Schedule();
            $schedule->group_id = $group->id;
            $schedule->start_hour = $request->start_time;
            $schedule->day_of_week = $request->day;
            $schedule->save();
        });

        return redirect()->route('admin.horarios');

    }
}
