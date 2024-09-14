<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\RequestStudentPayment;
use App\Models\Student;
use App\Models\StudentPaymentDone;
use App\Models\StudentPaymentMethods;
use App\Models\StudentPaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddPaymentStudentController extends Controller
{
    public function myPayments(Request $request)
    {
        $title = 'Solicitudes de pago';

        $name = $request->name;
        $rol = $request->rol;
        $photo = $request->photo;
        $links = $request->links;

        $myPayments = RequestStudentPayment::where('student_id', $request->studentId)->get();

        $myPayments->map(function ($payment) {
            $payment->parsedCreatedAt = date('d/m/Y', strtotime($payment->created_at));
            return $payment;
        });

        return view('academia.student.my-payments', compact('title', 'name', 'rol', 'photo', 'links', 'myPayments'));
    }

    public function addPayment(Request $request)
    {
        $title = 'Registrar pago';

        $name = $request->name;
        $rol = $request->rol;
        $photo = $request->photo;
        $links = $request->links;

        $studentId = $request->studentId;

        $student = Student::find($studentId);

        $hasInscriptionPayment = StudentPaymentDone::join('student_payment_types as type', 'type.id', '=', 'student_payment_done.type_id')
            ->where('type.name', 'Inscripción')
            ->where('student_payment_done.student_id', $studentId)
            ->select('student_payment_done.*')
            ->get();

        $paymentTypes = count($hasInscriptionPayment) > 0 ? StudentPaymentType::where('active', true)->where('name', '!=', 'Inscripción')->get() : StudentPaymentType::where('active', true)->get();
        $paymentMethods = StudentPaymentMethods::where('active', true)->get();
        $courseByStudent = Group::where('student_id', $studentId)->get();

        return view('academia.student.add-payment', compact('title', 'name', 'rol', 'photo', 'links', 'student', 'paymentTypes', 'courseByStudent', 'paymentMethods'));
    }

    public function savePayment(Request $request)
    {
        $extension = $request->voucher->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $request->voucher->move(public_path('img/users/students/payments'), $fileName);

        $requestStudentPayment = new RequestStudentPayment();
        $requestStudentPayment->amount_to_pay = $request->amount_to_pay;
        $requestStudentPayment->amount_paid = $request->amount_paid;
        $requestStudentPayment->due_date = $request->due_date;
        $requestStudentPayment->student_id = $request->student_id;
        $requestStudentPayment->group_id = $request->group_id;
        $requestStudentPayment->rate = $request->rate;
        $requestStudentPayment->is_paid = $request->amount_to_pay <= $request->amount_paid;
        $requestStudentPayment->payment_type_id = $request->payment_type_id;
        $requestStudentPayment->payment_method_id = $request->payment_method_id;
        $requestStudentPayment->voucher = $fileName;
        $requestStudentPayment->voucher_date = $request->voucher_date;
        $requestStudentPayment->reference = $request->reference;
        $requestStudentPayment->save();

        return redirect()->route('admin.estudiantes.pagos');
    }
}
