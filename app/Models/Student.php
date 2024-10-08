<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function representative()
    {
        return $this->hasOne(Representative::class);
    }

    public function paymentsData()
    {
        return $this->hasOne(StudentPaymentsData::class);
    }

    public function paymentsDone()
    {
        return $this->hasMany(StudentPaymentDone::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

}
