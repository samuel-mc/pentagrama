<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUsuariosController extends Controller
{
    /**
     * Listado de usuarios.
     */
    public function index(Request $request) {
        $title = 'Usuarios';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $users = User::all();
        return view('academia.admin.users', compact('title', 'name', 'rol', 'links', 'users', 'photo'));
    }
}
