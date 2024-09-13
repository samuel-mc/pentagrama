<?php

namespace App\Http\Controllers;

use App\Models\LogbookStudent;
use Illuminate\Http\Request;

class LogbookStudentController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Bitácora';

        $name = $request->name;
        $rol = $request->rol;
        $photo = $request->photo;
        $links = $request->links;

        $studentId = $request->studentId;

        $logbooks = LogbookStudent::whereHas('group', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->get();

        return view('academia.student.logbook', compact('title', 'name', 'rol', 'photo', 'links', 'logbooks'));
    }
}
