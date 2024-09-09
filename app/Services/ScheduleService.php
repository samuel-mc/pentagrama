<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\TimeSlots;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use function MongoDB\BSON\toJSON;

class ScheduleService
{
    public function getScheduleAdmin(): array
    {
        $schedule = Schedule::where('active', 1)->get();
        $hours = $this->getScheduleHours();
        $days = $this->getScheduleDays();
        $scheduleResponse = [];

        for($i = 0; $i < count($hours) ;$i++) {
            $scheduleResponse[$hours[$i][0]] = [];
            for ($j = 1; $j < count($days); $j++) {
                $courses = $schedule->filter(function ($item) use ($hours, $i, $j) {
                    return $item->time_slot_id == $hours[$i][1] && $item->day_of_week == $j;
                });
                $scheduleResponse[$hours[$i][0]][$days[$j]] = $courses->map(function ($item) {
                    return (object) ['name' => $item->group->course->name . ' (' . "J" . ')', 'id' => $item->id];
                });
                for ($k = 0; $k < 4 - count($courses); $k++) {
                    $scheduleResponse[$hours[$i][0]][$days[$j]][] = (object) ['name' => '', 'id' => $hours[$i][1]];

                }
            }
        }

        Log::info("scheduleResponseeeee" . json_encode($scheduleResponse));

        return $scheduleResponse;
    }

    public function getScheduleDays(): array
    {
        return ['', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
    }

    public function getScheduleHours()
    {
        $hours = TimeSlots::all()->sortBy('hour')->sortBy('minute');
        $hours = $hours->map(function ($item) {
            $item->hour = str_pad($item->hour, 2, '0', STR_PAD_LEFT);
            $item->minute = str_pad($item->minute, 2, '0', STR_PAD_LEFT);
            return [$item->hour . ':' . $item->minute, $item->id];
        });
        return $hours;
    }

    public function getSheduleDaysAsObject(): array
    {
        return [
            (object) ['id' => 1, 'name' => 'Lunes'],
            (object) ['id' => 2, 'name' => 'Martes'],
            (object) ['id' => 3, 'name' => 'Miercoles'],
            (object) ['id' => 4, 'name' => 'Jueves'],
            (object) ['id' => 5, 'name' => 'Viernes'],
            (object) ['id' => 6, 'name' => 'Sabado'],
        ];

    }
}
