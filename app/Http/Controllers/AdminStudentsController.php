<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\StudentPaymentDone;
use App\Models\StudentPaymentMethods;
use App\Models\StudentPaymentType;

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
        $pagos = StudentPaymentDone::where('student_id', $id)->get();
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
        //obviar el pago de inscripcion
        // $hasInscriptionPayment = StudentPaymentDone::where('student_id', $student->id)->where('student_payment_types_id', 'Inscripción')->first();

        $hasInscriptionPayment = StudentPaymentDone::join('student_payment_types as type', 'type.id', '=', 'student_payment_done.type_id')
        ->where('type.name', 'Inscripción')
        ->select('student_payment_done.*')
        ->get();
        $paymentTypes = count($hasInscriptionPayment) > 0 ? StudentPaymentType::where('active', true)->where('name', '!=', 'Inscripción')->get() : StudentPaymentType::where('active', true)->get();
        $paymentMethods = StudentPaymentMethods::where('active', true)->get();
        return view('academia.admin.add-payment-student', compact('title', 'name', 'rol', 'links', 'student', 'paymentTypes', 'paymentMethods'));
    }

    /**
     * Store the payment.
     */
    public function savePayment(Request $request) {
        // dd($request->all());
        DB::transaction(function () use ($request) {
            $studentPaymentDone = new StudentPaymentDone();
            $studentPaymentDone->amount = $request->montoPagado;
            $studentPaymentDone->student_id = $request->student_id;
            $studentPaymentDone->type_id = $request->payment_type;
            $studentPaymentDone->method_id = $request->payment_method;
            $studentPaymentDone->amount_paid = $request->montoTotal;
            $studentPaymentDone->amount_due = $request->montoRestante;
            $studentPaymentDone->due_date = $request->pay_before;
            $studentPaymentDone->voucher = $request->capture_photo;
            $studentPaymentDone->voucher_date = $request->capture_date;
            $studentPaymentDone->save();

        });

        return redirect("/admin/estudiantes/{$request->student_id}/pagos");
    }
}
