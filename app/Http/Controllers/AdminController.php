<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\Models\User;

define ("linksAdmin", [
    (object) ['url' => '/admin', 'name' => 'Dashboard', 'icon' => 'home.png'],
    (object) ['url' => '/admin/profesores', 'name' => 'Profesores', 'icon' => 'profesor.png'],
]);

class AdminController extends Controller
{

    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $title = 'Dashboard';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = [
            (object) ['url' => '/admin', 'name' => 'Dashboard', 'icon' => 'home.png'],
            (object) ['url' => '/admin/profesores', 'name' => 'Profesores', 'icon' => 'profesor.png'],
        ];
        return view('academia.admin.dashboard', compact('title', 'name', 'rol', 'links'));
    }

    /**
     * Display the teachers list.
     */
    public function teachers() {
        $title = 'Profesores';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        $teachers = Teacher::all();
        return view('academia.admin.teachers', compact('title', 'name', 'rol', 'links', 'teachers'));
    }

    /**
     * Display the screen to add a new teacher.
     */
    public function addTeacher() {
        $title = 'Agregar profesor';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = linksAdmin;
        return view('academia.admin.add-teacher', compact('title', 'name', 'rol', 'links'));
    }

    /**
     * Save a new teacher.
     */
    public function saveTeacher(Request $request) {
        // dd($request->all());
        DB::transaction(function () use ($request) {
            // Crear el usuario
            $user = new User();
            $user->email  = $request->correo;
            $user->password = bcrypt($request->contrasena);
            $user->save();
    
            // Crear el profesor asociado al usuario
            $teacher = new Teacher();
            $teacher->name = $request->nombre;
            $teacher->last_name = $request->apellido;
            $teacher->id_card = $request->cedula;
            $teacher->birthday = $request->fechaNacimiento;
            $teacher->address = $request->direccion;
            $teacher->whatsapp_number = $request->numeroWhatsApp;
            $teacher->another_number = $request->numeroEmergencia;
            $teacher->user_id = $user->id;
            $teacher->photo = $request->foto;
            $teacher->save();
        });

        return redirect('/admin/profesores');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
