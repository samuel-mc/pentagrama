<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\TimeSlotByTeacher;
use App\Models\TimeSlots;
use Illuminate\Support\Facades\Log;

class ScheduleService
{
    public function getScheduleAdmin(): array
    {
        $schedule = Schedule::where('active', 1)->get();
        $hours = $this->getScheduleHours();
        $days = $this->getScheduleDays();
        $scheduleResponse = [];

        for ($i = 0; $i < count($hours); $i++) {
            $scheduleResponse[$hours[$i][0]] = [];
            for ($j = 1; $j < count($days); $j++) {
                $courses = $schedule->filter(function ($item) use ($hours, $i, $j) {
                    return $item->time_slot_id == $hours[$i][1] && $item->day_of_week == $j;
                });
                $scheduleResponse[$hours[$i][0]][$days[$j]] = $courses->map(function ($item) {
                    return (object)['name' => $item->group->course->name . ' (' . "J" . ')', 'id' => $item->id];
                });
                for ($k = 0; $k < 4 - count($courses); $k++) {
                    $scheduleResponse[$hours[$i][0]][$days[$j]][] = (object)['name' => '', 'id' => $hours[$i][1]];

                }
            }
        }

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
            (object)['id' => 1, 'name' => 'Lunes'],
            (object)['id' => 2, 'name' => 'Martes'],
            (object)['id' => 3, 'name' => 'Miercoles'],
            (object)['id' => 4, 'name' => 'Jueves'],
            (object)['id' => 5, 'name' => 'Viernes'],
            (object)['id' => 6, 'name' => 'Sabado'],
        ];

    }

    public function getAvailabilyScheduleByTeacher($id): array
    {
        $availableSchedules = TimeSlotByTeacher::where('teacher_id', $id)->get();
        $groupsByTeacher = Group::where('teacher_id', $id)->get();
        $groupsByTeacherFlat = [];
        foreach ($groupsByTeacher as $group) {
            foreach ($group->schedules as $schedule) {
                $groupsByTeacherFlat[] = (object)[
                    'id' => $schedule->id,
                    'course' => $group->course->name,
                    'time_slot_id' => $schedule->time_slot_id,
                    'day_of_week' => $schedule->day_of_week
                ];
            }
        }
        $groupsByTeacherFlat = collect($groupsByTeacherFlat);
        $hours = $this->getScheduleHours();
        $days = $this->getScheduleDays();
        $scheduleResponse = [];

        for ($i = 0; $i < count($hours); $i++) {
            $scheduleResponse[$hours[$i][0]] = [];
            for ($j = 1; $j < count($days); $j++) {
                $groupCurrentTime = $groupsByTeacherFlat->filter(function ($item) use ($hours, $i, $j) {
                    return $item->time_slot_id == $hours[$i][1] && $item->day_of_week == $j;
                })->first();
                if ($groupCurrentTime) {
                    $scheduleResponse[$hours[$i][0]][$days[$j]] = (object)[
                        'id' => $groupCurrentTime->id,
                        'name' => $groupCurrentTime->course . ' (' . "J" . ')',
                        'time_slot_id' => $groupCurrentTime->time_slot_id,
                        'day_of_week' => $groupCurrentTime->day_of_week
                    ];
                } else {
                    $avalible = $availableSchedules->filter(function ($item) use ($hours, $i, $j) {
                        return $item->time_slot_id == $hours[$i][1] && $item->day_of_week == $j;
                    })->first();

                    $name = $avalible ? 'Disponible' : 'No disponible';
                    $scheduleResponse[$hours[$i][0]][$days[$j]] = (object)[
                        'id' => '',
                        'name' => $name,
                        'time_slot_id' => $hours[$i][1],
                        'day_of_week' => $j
                    ];
                }
            }
        }

        return $scheduleResponse;
    }

    public function getScheduleByStudent($id)
    {
        $groups = Group::where('student_id', $id)->get();
        $hours = $this->getScheduleHours();
        $days = $this->getScheduleDays();
        $scheduleResponse = [];

        $schedulesByGroup = [];

        foreach ($groups as $group) {
            foreach ($group->schedules as $schedule) {
                $schedulesByGroup[] = (object)[
                    'id' => $group->id,
                    'course' => $group->course->name,
                    'time_slot_id' => $schedule->time_slot_id,
                    'day_of_week' => $schedule->day_of_week
                ];
            }
        }

        $schedulesByGroup = collect($schedulesByGroup);

        for ($i = 0; $i < count($hours); $i++) {
            $scheduleResponse[$hours[$i][0]] = [];
            for ($j = 1; $j < count($days); $j++) {
                $course = $schedulesByGroup->filter(function ($item) use ($hours, $i, $j) {
                    return $item->time_slot_id == $hours[$i][1] && $item->day_of_week == $j;
                });
                $scheduleResponse[$hours[$i][0]][$days[$j]] = $course->map(function ($item) {
                    return (object)['name' => $item->course, 'id' => $item->id];
                })->first();
            }
        }



        return $scheduleResponse;

    }
}
