<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Group;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display the teacher dashboard.
     */
    public function displayTeacherDashboard(Request $request)
    {
        $title = 'Dashboard';
        $name = $request->name;
        $rol = $request->rol;
        $links = app('teacherLinks');
        $photo = $request->photo;

        $dayName = Carbon::now()->dayName;

        $teacherId = $request->teacherId;

        $schedule = $this->scheduleService->getScheduleByTeacherAndDay($teacherId);

        $studentsByDay = $this->scheduleService->getStudentsByDay($teacherId);

        return view('academia.dashboard.teacher', compact('title', 'name', 'rol', 'links', 'photo', 'dayName', 'schedule', 'studentsByDay'));

    }

    public function displayStudentDashboard(Request $request)
    {
        $title = 'Dashboard';

        $name = $request->name;
        $rol = $request->rol;
        $links = app('studentLinks');
        $photo = $request->photo;

        $studentId = $request->studentId;

        $groups = Group::where('student_id', $studentId)->get();

        $schedules = [];
        foreach ($groups as $group) {
            foreach ($group->schedules as $schedule) {
                $schedules[] = [
                    'course' => $group->course->name,
                    'teacher' => $group->teacher->name . ' ' . $group->teacher->last_name,
                    'day' => $schedule->day_of_week,
                    'hour' => $this->fillCeros($schedule->timeSlot->hour) . ':' . $this->fillCeros($schedule->timeSlot->minute),
                ];
            }
        }

        $lastScheduleDated = $this->getLastClass($schedules);
        $nextScheduleDated = $this->getNextClass($schedules);

        $days = $this->scheduleService->getScheduleDays();

        $scheduleByStudent  = $this->scheduleService->getScheduleByStudent($studentId);

//        dd($scheduleByStudent);

        $paymentDates = $groups->map(function ($item) {
            return (object)[
                "paymentDate" =>$item->monthly_payment_date,
                "amount" => $item->monthly_payment . ' $',
                "paymenDateFormated" => $this->getNextPaymentDate($item->monthly_payment_date),
                "course" => $item->course->name,
            ];
        });


        return view('academia.student.dashboard', compact('title', 'name', 'rol', 'links', 'photo', 'lastScheduleDated', 'nextScheduleDated', 'paymentDates', 'scheduleByStudent', 'days'));

    }

    private function getLastClass($schedules): array
    {
        $lastScheduleDated = [];

        foreach ($schedules as $schedule) {

            $initialDate = Carbon::now()->subDays(7);
            $currentDay = $initialDate;
            $endDate = Carbon::now();


            while ($currentDay->lte($endDate)) {
                $dayOfWeek = $currentDay->dayOfWeek;
                if ($dayOfWeek == $schedule['day']) {
                    $lastScheduleDated[] = [
                        'course' => $schedule['course'],
                        'teacher' => $schedule['teacher'],
                        'day' => $schedule['day'],
                        'hour' => $schedule['hour'],
                        'date' => $currentDay->format('d/m/Y'),
                    ];
                }
                $currentDay->addDay();
            }
        }

        return collect($lastScheduleDated)->sortBy('date')->last();
    }

    public function getNextClass($schedules): array
    {
        $nextScheduleDated = [];

        foreach ($schedules as $schedule) {

            $initialDate = Carbon::now();
            $currentDay = $initialDate;
            $endDate = Carbon::now()->addDays(7);

            while ($currentDay->lte($endDate)) {
                $dayOfWeek = $currentDay->dayOfWeek;
                if ($dayOfWeek == $schedule['day']) {
                    $nextScheduleDated[] = [
                        'course' => $schedule['course'],
                        'teacher' => $schedule['teacher'],
                        'day' => $schedule['day'],
                        'hour' => $schedule['hour'],
                        'date' => $currentDay->format('d/m/Y'),
                    ];
                }
                $currentDay->addDay();
            }
        }

        return collect($nextScheduleDated)->sortBy('date')->first();

    }

    private function fillCeros(string $number): string
    {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
    }

    public function getNextPaymentDate(string $date): string
    {
        $paymentDate = Carbon::parse($date);
        $currentDate = Carbon::now();
        $diff = $currentDate->diffInMonths($paymentDate);

        $nextPaymentDate = $diff > 0 ? $paymentDate->addMonths($diff) : $paymentDate->addMonths(1);

        return $nextPaymentDate->format('d/m/Y');
    }
}
