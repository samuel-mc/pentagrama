<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Student;
use App\Models\StudentPaymentDone;

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
        $students = Student::orderBy('name', 'asc')->get();
        foreach ($students as $student) {
            $formatedPaymentDate = Carbon::parse($student->paymentsData->payment_date)->format('d/m');
            $student->formatedPaymentDate = $formatedPaymentDate;
            $formattedCreatedAt = Carbon::parse($student->created_at)->format('d/m/Y');
            $student->formattedCreatedAt = $formattedCreatedAt;
        }
        return view('academia.admin.students', compact('title', 'name', 'rol', 'links', 'students'));
    }

    /**
     * Display the student detail.
     */
    public function studentDetail($id)
    {
        $title = 'Detalle';
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('adminLinks');
        $student = Student::find($id);
        $formattedCreatedAt = Carbon::parse($student->created_at)->format('d/m/Y');
        $student->formattedCreatedAt = $formattedCreatedAt;
        $formatedBirthdate = Carbon::parse($student->birthdate)->format('d/m/Y');
        $student->formatedBirthdate = $formatedBirthdate;
        $formatedPaymentDate = Carbon::parse($student->paymentsData->payment_date)->format('d/m');
        $student->formatedPaymentDate = $formatedPaymentDate;
        return view('academia.admin.detail-student', compact('title', 'name', 'rol', 'links', 'student'));
    }

    /**
     * Display the student payments.
     */

    public function studentPayments($id)
    {
        $student = Student::find($id);
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $title = 'Pagos: ' . $student->name . ' ' . $student->last_name;
        $links = app('adminLinks');
        $pagos = StudentPaymentDone::join('student_payments_data as pdata', 'pdata.id', '=', 'student_payment_done.id')
            ->where('pdata.student_id', 1)
            ->select('student_payment_done.*')
            ->get();
        if (!is_null($pagos) && is_array($pagos)) {
            // Format the date
            $pagos = $pagos;
        } else {
            $pagos = [];
        }
        return view('academia.admin.payments-student', compact('title', 'name', 'rol', 'links', 'pagos', 'student'));
    }

    /**
     * Display the add payment form.
     */
    public function addPayment($id) {
        $student = Student::find($id);
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $links = app('adminLinks');
        $title = 'Agregar Pago: ' . $student->name . ' ' . $student->last_name;
        $formattedPaymentDate = Carbon::parse($student->paymentsData->payment_date)->format('d/m');
        $student->formattedPaymentDate = $formattedPaymentDate;
        return view('academia.admin.add-payment-student', compact('title', 'name', 'rol', 'links', 'student'));
    }
}
