<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\StudentPaymentDone;
use App\Models\StudentPaymentMethods;
use App\Models\StudentPaymentType;
use App\Models\StudentPaymentDoneItem;
use App\Models\StudentsGroup;

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
        $pagos->map(function ($pago) {
            $pago->date = Carbon::parse($pago->created_at)->format('d/m/Y');
            if ($pago->due_date != null) {
                $pago->due_date = Carbon::parse($pago->due_date)->format('d/m/Y');
            }
            $pago->amountPaid = $pago->studentPaymentDoneItems->sum('amount_paid');
            $pago->amountDue = $pago->amount - $pago->amountPaid;
            return $pago;
        });
        // dd($pagos->first()->studentPaymentType);
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

        $hasInscriptionPayment = StudentPaymentDone::join('student_payment_types as type', 'type.id', '=', 'student_payment_done.type_id')
        ->where('type.name', 'Inscripción')
        ->select('student_payment_done.*')
        ->get();
        
        $paymentTypes = count($hasInscriptionPayment) > 0 ? StudentPaymentType::where('active', true)->where('name', '!=', 'Inscripción')->get() : StudentPaymentType::where('active', true)->get();
        $paymentMethods = StudentPaymentMethods::where('active', true)->get();
        $groupsByStudent = $student->studentsGroups->map(function ($group) {
            $group->payment_date = Carbon::parse($group->payment_date)->format('d/m/Y');
        });
        return view('academia.admin.add-payment-student', compact('title', 'name', 'rol', 'links', 'student', 'paymentTypes', 'paymentMethods', 'groupsByStudent'));
    }

    /**
     * Store the payment.
     */
    public function savePayment(Request $request) {
        // dd($request->all());
        DB::transaction(function () use ($request) {
            $student_payment_done_id = null;
            if ($request->student_payment_donte_id == null) {
                $studentPaymentDone = new StudentPaymentDone();
                $studentPaymentDone->amount = $request->montoAPagar; // monto a pagar
                $studentPaymentDone->student_id = $request->student_id;
                $studentPaymentDone->type_id = $request->payment_type;
                $studentPaymentDone->rate = $request->tasa;
                $studentPaymentDone->is_paid = $request->montoRestante == 0 || $request->payment_type == 3;
                $studentPaymentDone->due_date = $request->pay_before;
                $studentPaymentDone->group_id = $request->grupoAPagar;
                $studentPaymentDone->save();
                $student_payment_done_id = $studentPaymentDone->id;
            } else {
                $student_payment_done_id = $request->student_payment_donte_id;
            }

            $itm = new StudentPaymentDoneItem();

            $itm->method_id = $request->payment_method;
            $itm->amount_paid = $request->montoPagado; // monto que ha sido pagado
            $itm->voucher = $request->capture_photo;
            $itm->voucher_date = $request->capture_date;
            $itm->reference = $request->referencia;
            $itm->student_payment_done_id = $student_payment_done_id;
            $itm->save();

            if ($request->student_payment_donte_id != null) {
                $studentPaymentDone = StudentPaymentDone::find($student_payment_done_id);
                $studentPaymentDone->is_paid = $request->montoRestante == 0;
                $studentPaymentDone->save();
            }

        });

        return redirect("/admin/estudiantes/{$request->student_id}/pagos");
    }

    /**
     * Display the detail of the payment.
     */
    public function detailPayment($paymentId) {
        // dd($paymentId);
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $title = 'Detalle de Pago';
        $links = app('adminLinks');
        $payment = StudentPaymentDone::find($paymentId);
        $student = Student::find($payment->student_id);

        $payment->amountPaid = $payment->studentPaymentDoneItems->sum('amount_paid');
        $payment->amountDue = $payment->amount - $payment->amountPaid;
        $payment->dueDate = Carbon::parse($payment->due_date)->format('d/m/Y');

        $payment->studentPaymentDoneItems->map(function ($item) {
            $item->formattedCreatedAt = Carbon::parse($item->created_at)->format('d/m/Y');
            $item->formattedVoucherDate = Carbon::parse($item->voucher_date)->format('d/m/Y');
            return $item;
        });

        $paymentTypes = StudentPaymentType::where('active', true)->get();
        $paymentMethods = StudentPaymentMethods::where('active', true)->get();
        return view('academia.admin.detail-payment-student', compact('title', 'name', 'rol', 'links', 'payment', 'student', 'paymentTypes', 'paymentMethods'));
    }

    /**
     * Display the groups of a student.
     */
    public function studentGroups($id) {
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $title = 'Grupos';
        $links = app('adminLinks');
        $groupsByStudent = StudentsGroup::where('id_student', $id)->get();
        // dd($groupsByStudent);
        return view('academia.admin.student-groups', compact('title', 'name', 'rol', 'links', 'id', 'groupsByStudent'));
    }

    /**
     * Display the add group form.
     */
    public function addGroup($id) {
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $title = 'Agregar Grupo';
        $links = app('adminLinks');
        $groupsByStudent = DB::table('students_groups')->where('id_student', $id)->where('active', '1')->pluck('id_group');
        $groups = Group::where('active', true)->whereNotIn('id', $groupsByStudent)->get();
        return view('academia.admin.add-student-group', compact('title', 'name', 'rol', 'links', 'id', 'groups'));
    }

    /**
     * Store the group.
     */
    public function saveGroup(Request $request) {
        DB::table('students_groups')->insert([
            'id_student' => $request->student_id,
            'id_group' => $request->group_id,
            'monthly_payment' => $request->monthly_payment,
            'payment_date' => $request->payment_date
        ]);
        return redirect("/admin/estudiantes/{$request->student_id}/grupos");
    }
        
}
