<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\LogbookStudent;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogbookTeacherController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Bitácora';
        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $teacherId = $request->teacherId;

        $logbooks = LogbookStudent::whereHas('group', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        $logbooks = $logbooks->sortByDesc('date');

        return view('academia.teacher.logbook', compact('title', 'name', 'rol', 'links', 'photo', 'logbooks'));
    }

    public function addLogbook(Request $request)
    {
        $title = 'Bitácora';
        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $teacherId = $request->teacherId;

        $groupsByTeacher = Group::where('teacher_id', $teacherId)->get();

        return view('academia.teacher.add-logbook', compact('title', 'name', 'rol', 'links', 'photo', 'groupsByTeacher'));
    }

    public function saveLogbook(Request $request)
    {
        $fileName = null;
        if ($request->hasFile('image')) {
            $extension = $request->image->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $request->image->move(public_path('img/users/teachers/logbook'), $fileName);
        }
        $logbook = new LogbookStudent();
        $logbook->group_id = $request->course;
        $logbook->date = $request->date;
        $logbook->title = $request->topic;
        $logbook->song = $request->songs;
        $logbook->image = $fileName;
        $logbook->save();

        return redirect()->route('admin.profesores.bitacora');

    }

    public function addImage(Request $request)
    {
        $title = 'Bitácora: Agregar Imagen';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $logbookId = $request->logbookId;
        $logbook = LogbookStudent::find($logbookId);

        return view('academia.teacher.add-logbook-img', compact('title', 'name', 'rol', 'links', 'photo', 'logbook'));
    }

    public function saveImage(Request $request)
    {
        $extension = $request->image->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $request->image->move(public_path('img/users/teachers/logbook'), $fileName);
        $logbook = LogbookStudent::find($request->logbook_id);
        $logbook->image = $fileName;
        $logbook->save();

        return redirect()->route('admin.profesores.bitacora');
    }
}
