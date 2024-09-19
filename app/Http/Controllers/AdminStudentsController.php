<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\RequestStudentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\StudentPaymentDone;
use App\Models\StudentPaymentMethods;
use App\Models\StudentPaymentType;
use App\Models\StudentPaymentDoneItem;
use App\Models\StudentsGroup;
use Illuminate\Support\Str;

class AdminStudentsController extends Controller
{
    /**
     * Display the index.
     */
    public function index(Request $request)
    {
        $title = 'Estudiantes';
        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;
        $students = Student::orderBy('name', 'asc')->get();
        foreach ($students as $student) {
            $formatedPaymentDate = Carbon::parse($student->paymentsData->payment_date)->format('d/m');
            $student->formatedPaymentDate = $formatedPaymentDate;
            $formattedCreatedAt = Carbon::parse($student->created_at)->format('d/m/Y');
            $student->formattedCreatedAt = $formattedCreatedAt;
        }
        return view('academia.admin.students', compact('title', 'name', 'rol', 'links', 'students', 'photo'));
    }

    public function updatePassword(Request $request) {
        // dd($request);
        $student = Student::find($request->id);
        $student->user->password = bcrypt($request->password);
        $student->user->save();
        //redirect to previous page with success message
        return redirect()->back()->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Display the student detail.
     */
    public function studentDetail($id, Request $request)
    {
        $title = 'Detalle';
        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;
        $student = Student::find($id);
        $formattedCreatedAt = Carbon::parse($student->created_at)->format('d/m/Y');
        $student->formattedCreatedAt = $formattedCreatedAt;
        $formatedBirthdate = Carbon::parse($student->birthdate)->format('d/m/Y');
        $student->formatedBirthdate = $formatedBirthdate;
        $formatedPaymentDate = Carbon::parse($student->paymentsData->payment_date)->format('d/m');
        $student->formatedPaymentDate = $formatedPaymentDate;
        return view('academia.admin.detail-student', compact('title', 'name', 'rol', 'links', 'student', 'photo'));
    }

    /**
     * Display the student payments.
     */

    public function studentPayments($id, Request $request)
    {
        $student = Student::find($id);
        $title = 'Pagos: ' . $student->name . ' ' . $student->last_name;

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $pagos = StudentPaymentDone::where('student_id', $id)->get();

        $paymentsRequest = RequestStudentPayment::where('student_id', $id)->get();
        $paymentsRequest = $paymentsRequest->map(function ($payment) {
            $formattedCreatedAt = Carbon::parse($payment->created_at)->format('d/m/Y');
            $payment->formattedCreatedAt = $formattedCreatedAt;
            return $payment;
        });

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
        return view('academia.admin.payments-student', compact('title', 'name', 'rol', 'links', 'pagos', 'student', 'photo', 'paymentsRequest'));
    }

    /**
     * Display the add payment form.
     */
    public function addPayment($id, Request $request) {
        $student = Student::find($id);
        $title = 'Agregar Pago: ' . $student->name . ' ' . $student->last_name;

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $formattedPaymentDate = Carbon::parse($student->paymentsData->payment_date)->format('d/m');
        $student->formattedPaymentDate = $formattedPaymentDate;

        $hasInscriptionPayment = StudentPaymentDone::join('student_payment_types as type', 'type.id', '=', 'student_payment_done.type_id')
        ->where('type.name', 'Inscripción')
        ->where('student_payment_done.student_id', $id)
        ->select('student_payment_done.*')
        ->get();

        $paymentTypes = count($hasInscriptionPayment) > 0 ? StudentPaymentType::where('active', true)->where('name', '!=', 'Inscripción')->get() : StudentPaymentType::where('active', true)->get();
        $paymentMethods = StudentPaymentMethods::where('active', true)->get();
        $courseByStudent = Group::where('student_id', $id)->get();
        return view('academia.admin.add-payment-student', compact('title', 'name', 'rol', 'links', 'student', 'paymentTypes', 'paymentMethods', 'courseByStudent', 'photo'));
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

            $fileName = Str::uuid() . '.' . $request->capture_photo->extension();
            $request->capture_photo->move(public_path('img/users/students/payments'), $fileName);
            $itm->method_id = $request->payment_method;
            $itm->amount_paid = $request->montoPagado; // monto que ha sido pagado
            $itm->voucher = $fileName;
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
    public function detailPayment($paymentId, Request $request) {
        // dd($paymentId);
        $title = 'Detalle de Pago';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

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
        return view('academia.admin.detail-payment-student', compact('title', 'name', 'rol', 'links', 'payment', 'student', 'paymentTypes', 'paymentMethods', 'photo'));
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

    /**
     * Display the acounts list.
     */

    public function accounts(Request $request) {
        $title = 'Cuentas';

        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;

        $students = [];

        $searchValue = $request->search ?? "";

        if ($request->has("search")) {
            $students = Student::where('name', 'like', '%' . $request->search . '%')->orWhere('last_name', 'like', '%' . $request->search . '%')->orderBy('last_name', 'asc')->get();
        } else {
            $students = Student::orderBy('name', 'asc')->get();
        }

        $students->map(function ($student) {
            $student->courses = join(', ', $student->groups->map(function ($group) {
                return $group->course->name;
            })->toArray());
            return $student;
        });

        return view('academia.admin.accounts', compact('title', 'name', 'rol', 'links', 'students', 'searchValue', 'photo'));
    }

    public function accountDetail($id) {
        $name = 'Elias Cordova';
        $rol = 'Admin';
        $title = 'Detalle de Cuenta';
        $links = app('adminLinks');
        $student = Student::find($id);

        $student->formatedBirthdate = Carbon::parse($student->birthdate)->format('d/m/Y');
        $student->age = Carbon::parse($student->birthdate)->age;
        $student->courses = join(', ', $student->groups->map(function ($group) {
            return $group->course->name;
        })->toArray());

        $student->studentsGroups = $student->groups->map(function ($group) {
            $group->formattedPaymentDate = Carbon::parse($group->payment_date)->format('d/m/Y');
            return $group;
        });

        $student->paymentsDone = $student->paymentsDone->map(function ($payment) {
            $payment->date = Carbon::parse($payment->created_at)->format('d/m/Y');
            $payment->method = join(', ', $payment->studentPaymentDoneItems->map(function ($item) {
                return $item->studentPaymentMethods->name;
            })->toArray());
            $payment->amountTotal = $payment->studentPaymentDoneItems->sum('amount_paid');
            $payment->amounts = join(', ', $payment->studentPaymentDoneItems->map(function ($item) {
                return $item->amount_paid;
            })->toArray());
            $payment->validate = $payment->is_paid;
            return $payment;
        })->take(1);

        return view('academia.admin.detail-account', compact('title', 'name', 'rol', 'links', 'student'));
    }

}
