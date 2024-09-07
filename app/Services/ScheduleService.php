<?php

namespace App\Services;

use App\Models\Schedule;

class ScheduleService
{
    public function getScheduleAdmin(): array
    {
        $schedule = Schedule::where('active', 1)->get();
        $hours = $schedule->map(function ($item) {
            return $item->start_hour;
        })->unique()->sort();
        $days = $this->getScheduleDays();
        $scheduleResponse = [];

        for($i = 0; $i < count($hours) ;$i++) {
            $scheduleResponse[$hours[$i]] = [];
            for ($j = 1; $j < count($days); $j++) {
                $courses = $schedule->filter(function ($item) use ($hours, $i, $j) {
                    return $item->start_hour == $hours[$i] && $item->day_of_week == $j;
                });
                $scheduleResponse[$hours[$i]][$days[$j]] = $courses->map(function ($item) {
                    return $item->group->course->name . ' (' . "J" . ')';
                });
                for ($k = 0; $k < 4 - count($courses); $k++) {
                    $scheduleResponse[$hours[$i]][$days[$j]][] = '';
                }
            }
        }

        return $scheduleResponse;
    }

    public function getScheduleDays(): array
    {
        return ['', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
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
