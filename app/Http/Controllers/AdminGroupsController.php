<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Age;
use App\Models\Schedule;

class AdminGroupsController extends Controller
{
    /**
     * Display a listing of groups.
     */
    public function index() {
        $title = 'Grupos';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('adminLinks');
        $groups = Group::where('active', 1)->get();
        return view('academia.admin.groups', compact('title', 'name', 'rol', 'links', 'groups'));
    }

    /**
     * Show the form for creating a new group.
     */
    public function addGroup() {
        $title = 'Agregar Grupo';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('adminLinks');
        $teachers = Teacher::where('active', 1)->get();
        $courses = Course::where('active', 1)->get();
        $ages = Age::where('active', 1)->get();
        return view('academia.admin.add-group', compact('title', 'name', 'rol', 'links', 'teachers', 'courses', 'ages'));
    }

    /**
     * Store a newly created group in storage.
     */
    public function saveGroup(Request $request) {
        // dd($request->all());
        DB::transaction(function () use ($request) {
            $group = new Group();
            $group->name = $request->name;
            $group->teacher_id = $request->teacher;
            $group->course_id = $request->course;
            $group->age_id = $request->age;
            $group->save();

            for ($i = 1; $i <= $request->schedules; $i++) {
                $schedules = new Schedule();
                $schedules->group_id = $group->id;
                $schedules->start_hour = $request->input('start_time_schedule'.$i);
                $schedules->end_hour = $request->input('end_time_schedule'.$i);
                $schedules->day_of_week = $request->input('day_schedule'.$i);
                $schedules->save();
            }
        });
        return redirect('/admin/grupos');
    }
}
