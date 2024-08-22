<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPaymentMethods extends Model
{
    use HasFactory;

    protected $table = 'student_payment_methods';

    public function studentPaymentDoneIte()
    {
        return $this->hasMany(StudentPaymentDoneItem::class);
    }
}
