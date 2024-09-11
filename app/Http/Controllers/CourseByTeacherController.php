<?php

namespace App\Http\Controllers;

use App\Models\CourseByTeacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function PHPUnit\Framework\logicalAnd;

class CourseByTeacherController extends Controller
{
    public function getCoursesByTeacher($id): JsonResponse
    {
        $teachers = CourseByTeacher::where('course_id', $id)->where('active', 1)->get();
        $teachers = $teachers->map(function ($teacher) {
            return [
                'id' => $teacher->teacher->id,
                'name' => $teacher->teacher->name . ' ' . $teacher->teacher->last_name,
            ];
        });
        return response()->json($teachers);
    }

    public function setCourseByTeacher(Request $request)
    {
        $teacherId = $request->teacherId;
        $courseId = $request->courseId;

        $course = CourseByTeacher::where('teacher_id', $teacherId)->where('course_id', $courseId)->first();

        if ($course) {
            $course->delete();
        } else {
            $courseByTeacher = new CourseByTeacher();
            $courseByTeacher->teacher_id = $teacherId;
            $courseByTeacher->course_id = $courseId;
            $courseByTeacher->save();
        }

        return redirect(route('admin.profesores.horarios-disponibles'));
    }

}
