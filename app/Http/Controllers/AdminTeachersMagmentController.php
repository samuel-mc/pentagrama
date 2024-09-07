<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Str;

define("linksAdmin", [
    (object) ['url' => '/admin', 'name' => 'Dashboard', 'icon' => 'home.png'],
    (object) ['url' => '/admin/profesores', 'name' => 'Profesores', 'icon' => 'profesor.png'],
    (object) ['url' => '/admin/info-adicional', 'name' => 'Información adicional', 'icon' => 'info.png'],
]);

class AdminTeachersMagmentController extends Controller
{

    /**
     * Display the teachers list.
     */
    public function index(Request $request)
    {
        $title = 'Profesores';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $teachers = Teacher::where('active', 1)->get();
        $teachers->map(function ($teacher) {
            $teacher->courses = $teacher->groups->map(function ($group) {
                return $group->course->name;
            })->unique()->implode(', ');
        });
        return view('academia.admin.teachers', compact('title', 'name', 'rol', 'links', 'teachers', 'photo'));
    }

    /**
     * Display the screen to add a new teacher.
     */
    public function addTeacher(Request $request)
    {
        $title = 'Agregar profesor';

        $name = $request->name;
        $rol = $request->rol;
        $photo = $request->photo;
        $links = $request->links;

        return view('academia.admin.add-teacher', compact('title', 'name', 'rol', 'links', 'photo'));
    }

    /**
     * Save a new teacher.
     */
    public function saveTeacher(Request $request)
    {

        $fileName = Str::uuid() . '.' . $request->foto->extension();
        $request->foto->move(public_path('img/users/teachers'), $fileName);

        DB::transaction(function () use ($request, $fileName) {
            // Crear el usuario
            $user = new User();
            $user->username  = $request->username;
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
            $teacher->photo = $fileName;
            $teacher->save();
        });

        return redirect('/admin/profesores');
    }

    /**
     * Display the screen to edit a teacher.
     */
    public function editTeacher(string $id, Request $request)
    {
        $title = 'Editar profesor';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $teacher = Teacher::find($id);
        $formattedBirthday = Carbon::parse($teacher->birthday)->format('Y-m-d');
        $teacher->formattedBirthday = $formattedBirthday;
        return view('academia.admin.edit-teacher', compact('title', 'name', 'rol', 'links', 'teacher', 'photo'));
    }

    /**
     * Update a teacher.
     */
    public function updateTeacher(Request $request, string $id)
    {
        // dd($request->all());
        DB::transaction(function () use ($request, $id) {
            // Actualizar información del profesor
            $teacher = Teacher::find($id);
            $teacher->name = $request->nombre;
            $teacher->last_name = $request->apellido;
            $teacher->id_card = $request->cedula;
            $teacher->birthday = $request->fechaNacimiento;
            $teacher->address = $request->direccion;
            $teacher->whatsapp_number = $request->numeroWhatsApp;
            $teacher->another_number = $request->numeroEmergencia;
            $teacher->photo = $request->foto;
            $teacher->active = $request->active == 'on' ? 1 : 0;
            $teacher->save();
        });

        return redirect('/admin/profesores');
    }
}
