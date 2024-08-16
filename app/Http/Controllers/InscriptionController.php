<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HowFoundUs;
use App\Models\User;
use App\Models\Student;
use App\Models\Representative;
use App\Models\StudentPaymentsData;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    /**
     * Display the index.
     */
    public function index()
    {
        $title = 'Inscripción';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('adminLinks');
        $howFoundUs = HowFoundUs::orderBy('how', 'desc')->where('active', 1)->get();
        return view('academia.admin.inscription', compact('title', 'name', 'rol', 'links', 'howFoundUs'));
    }

    /**
     * Save the inscription.
     */
    public function save(Request $request)
    {
        $message = [
            'correo.unique' => 'El correo ya se encuentra registrado, prueba con uno diferente.',
        ];
        $request->validate([
            'correo' => 'unique:users,email',
        ], $message);

        $studentId = null;

        DB::transaction(function () use ($request) {
            // dd($request->all());
            $user = new User();
            $user->email = $request->correo;
            $user->password = bcrypt($request->contrasena);
            $user->save();

            $student = new Student();
            $student->name = $request->nombre;
            $student->last_name = $request->apellidos;
            $student->birthdate = $request->fecha_nacimiento;
            $student->gender = $request->genero;
            $student->modality = $request->modalidad;
            $student->user_id = $user->id;
            $student->photo = $request->foto;
            $student->save();

            $representative = new Representative();
            $representative->name = $request->nombre_representante;
            $representative->last_name = $request->apellidos_representante;
            $representative->id_card = $request->cedula_representante;
            $representative->whatsapp_number = $request->whatsapp_representante;
            $representative->another_number = $request->telefono_emergencia_representante;
            $representative->occupation = $request->ocupacion_representante;
            $representative->address = $request->direccion_representante;
            $representative->student_id = $student->id;
            $representative->how_found_us_id = $request->como_nos_encontraste;
            $representative->save();

            $studentPaymentsData = new StudentPaymentsData();
            $studentPaymentsData->student_id = $student->id;
            $studentPaymentsData->payment_method = $request->metodo_pago;
            $studentPaymentsData->monthly_payment = $request->monto;
            $studentPaymentsData->inscription_payment = $request->inscripcion;
            $studentPaymentsData->payment_date = $request->fechaPago;
            $studentPaymentsData->save();

            $studentId = $student->id;
        });
        
        return redirect('/admin/estudiantes/' . $studentId);
    }
}
