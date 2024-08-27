<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUsuariosController extends Controller
{
    /**
     * Listado de usuarios.
     */
    public function index() {
        $title = 'Usuarios';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('adminLinks');
        $users = User::all();
        return view('academia.admin.users', compact('title', 'name', 'rol', 'links', 'users'));
    }
}
