<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStudentPayment extends Model
{
    use HasFactory;

    public function method()
    {
        return $this->belongsTo(StudentPaymentMethods::class, 'payment_method_id');
    }

    public function type()
    {
        return $this->belongsTo(StudentPaymentType::class, 'payment_type_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
