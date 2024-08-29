<?php

namespace App\DTO;
class ScheduleDTO {
    public $hour;
    public $course_id;
    public $course;
    public $student_id;
    public $name;
    public $teacher_id;
    public $teacher;
    public $asistencia;

    public function __construct($hour, $course_id, $course, $student_id, $name, $teacher_id, $teacher, $asistencia)
    {
        $this->hour = $hour;
        $this->course_id = $course_id;
        $this->course = $course;
        $this->student_id = $student_id;
        $this->name = $name;
        $this->teacher_id = $teacher_id;
        $this->teacher = $teacher;
        $this->asistencia = $asistencia;
    }
}