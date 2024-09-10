<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseByTeacher;

class CourseByTeacherService
{
    protected ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function getCoursesByTeacher($teacherId)
    {
        $coursesByTeacher = CourseByTeacher::where('teacher_id', $teacherId)->get();
        $courses =  Course::where('active', 1)->get();

        $courses = $courses->map(function ($course) use ($coursesByTeacher) {
            $course->selected = $coursesByTeacher->contains('course_id', $course->id);
            return $course;
        });

        return $courses;
    }
}
