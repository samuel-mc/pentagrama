<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Personal;
use App\Models\Role;
use App\Models\User;

class AdminPersonalController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Personal';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $personal = Personal::orderBy('name', 'asc')->get();
        return view('academia.admin.personal', compact('title', 'name', 'rol', 'links', 'personal', 'photo'));
    }

    public function create(Request $request)
    {
        $title = 'Agregar Personal';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $types = Role::orderBy('name', 'asc')->get();
        return view('academia.admin.add-personal', compact('title', 'name', 'rol', 'links', 'types', 'photo'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $personal = new Personal();
            if ($request->need_login == '1') {
                $user = new User();
                $user->username = $request->username;
                $user->password = bcrypt($request->contrasena);
                $user->save();
                $personal->user_id = $user->id;
            }
            $personal->name = $request->nombre;
            $personal->lastname = $request->apellido;
            $personal->phone = $request->telefono;
            $personal->address = $request->direccion;
            $personal->salary = $request->salario;
            $personal->role_id = $request->rol;
            $personal->save();
        });
        return redirect('/admin/personal');
    }
}
