<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use App\Models\StudentPaymentDone;
use App\Models\StudentPaymentMethods;
use App\Models\StudentPaymentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReceptionistModulesController extends Controller
{
    public function registerPayment(Request $request)
    {
        $title = 'Registrar Pago';

        $name = $request->name;
        $rol = $request->rol;
        $photo = $request->photo;
        $links = $request->links;

        $students = Student::where('active', '1')->get();

        $paymentTypes = [];
        $courseByStudent = [];
        $paymentMethods = StudentPaymentMethods::where('active', true)->get();

        return view('academia.receptionist.add-payment', compact('title', 'name', 'rol', 'photo', 'links', 'students', 'paymentTypes', 'paymentMethods', 'courseByStudent'));
    }

    public function obtenerTiposDePagoPorEstudiante($id): JsonResponse
    {
        $hasInscriptionPayment = StudentPaymentDone::join('student_payment_types as type', 'type.id', '=', 'student_payment_done.type_id')
            ->where('type.name', 'Inscripción')
            ->where('student_payment_done.student_id', $id)
            ->select('student_payment_done.*')
            ->get();

        $paymentTypes = count($hasInscriptionPayment) > 0 ? StudentPaymentType::where('active', true)->where('name', '!=', 'Inscripción')->get() : StudentPaymentType::where('active', true)->get();

        return response()->json($paymentTypes);
    }

    public function obtenerGruposPorEstudiante($id)
    {
        $grupos = Group::where('student_id', $id)->get();
        $grupos->map(function ($grupo) {
            $grupo->name = $grupo->course->name;
            $grupo->formattedPaymentDate = Carbon::parse($grupo->payment_date)->format('d/m/Y');
            return $grupo;
        });
        return response()->json($grupos);
    }
}
