<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminStudentsController extends Controller
{
    /**
     * Display the index.
     */
    public function index()
    {
        $title = 'Estudiantes';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('adminLinks');
        return view('academia.admin.students', compact('title', 'name', 'rol', 'links'));
    }
}
