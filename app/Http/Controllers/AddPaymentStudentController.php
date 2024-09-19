<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\RequestStudentPayment;
use App\Models\Student;
use App\Models\StudentPaymentDone;
use App\Models\StudentPaymentDoneItem;
use App\Models\StudentPaymentMethods;
use App\Models\StudentPaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function approvePayment(Request $request)
    {
        $id = $request->id;
        $requestStudentPayment = RequestStudentPayment::find($id);
        if ($requestStudentPayment->accepted) {
            return response()->json(['success' => false]);
        }

        // dd($request->all());
        DB::transaction(function () use ($requestStudentPayment) {
            $studentPaymentDone = new StudentPaymentDone();
            $studentPaymentDone->amount = $requestStudentPayment->amount_to_pay; // monto a pagar
            $studentPaymentDone->student_id = $requestStudentPayment->student_id;
            $studentPaymentDone->type_id = $requestStudentPayment->payment_type_id;
            $studentPaymentDone->rate = $requestStudentPayment->rate;
            $montoRestante = $requestStudentPayment->amount_to_pay - $requestStudentPayment->amount_paid;
            $studentPaymentDone->is_paid = $montoRestante == 0 || $requestStudentPayment->payment_type_id == 3;
            $studentPaymentDone->due_date = $requestStudentPayment->due_date;
            $studentPaymentDone->group_id = $requestStudentPayment->group_id;
            $studentPaymentDone->save();
            $student_payment_done_id = $studentPaymentDone->id;

            $itm = new StudentPaymentDoneItem();

            $itm->method_id = $requestStudentPayment->payment_method_id;
            $itm->amount_paid = $requestStudentPayment->amount_paid; // monto que ha sido pagado
            $itm->voucher = $requestStudentPayment->voucher;
            $itm->voucher_date = $requestStudentPayment->voucher_date;
            $itm->reference = $requestStudentPayment->reference;
            $itm->student_payment_done_id = $student_payment_done_id;
            $itm->save();

            $requestStudentPayment->accepted = true;
            $requestStudentPayment->save();
        });
        return response()->json(['success' => true]);
    }

}
