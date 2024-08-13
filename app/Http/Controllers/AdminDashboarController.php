<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Dashboard';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('adminLinks');;
        return view('academia.admin.dashboard', compact('title', 'name', 'rol', 'links'));
    }
    
}
