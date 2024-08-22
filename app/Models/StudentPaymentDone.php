<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPaymentDone extends Model
{
    use HasFactory;
    protected $table = 'student_payment_done';

    public function studentPaymentType()
    {
        return $this->belongsTo(StudentPaymentType::class, 'type_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentPaymentDoneItems()
    {
        return $this->hasMany(StudentPaymentDoneItem::class);
    }

}
