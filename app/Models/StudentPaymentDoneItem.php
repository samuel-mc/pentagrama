<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPaymentDoneItem extends Model
{
    use HasFactory;

    protected $table = 'student_payment_done_items';

    public function studentPaymentDone()
    {
        return $this->belongsTo(StudentPaymentDone::class);
    }

    public function studentPaymentMethods()
    {
        return $this->belongsTo(StudentPaymentMethods::class, 'method_id');
    }
}
