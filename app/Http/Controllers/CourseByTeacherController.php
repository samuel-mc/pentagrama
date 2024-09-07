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
                'id' => $teacher->id,
                'name' => $teacher->teacher->name . ' ' . $teacher->teacher->last_name,
            ];
        });
        return response()->json($teachers);
    }
}
