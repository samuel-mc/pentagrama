<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPaymentType extends Model
{
    use HasFactory;
    protected $table = 'student_payment_types';

    public function studentPaymentDone()
    {
        return $this->hasMany(StudentPaymentDone::class);
    }

}
