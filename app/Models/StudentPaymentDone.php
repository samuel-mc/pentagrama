<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPaymentDone extends Model
{
    use HasFactory;
    protected $table = 'student_payment_done';

    public function paymentType()
    {
        return $this->belongsTo(StudentPaymentType::class, 'student_payment_types_id');
    }

    public function paymentData()
    {
        return $this->belongsTo(StudentPaymentsData::class);
    }
}
