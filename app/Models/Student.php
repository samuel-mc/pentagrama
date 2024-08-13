<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function representative()
    {
        return $this->hasOne(Representative::class);
    }

    public function paymentsData()
    {
        return $this->hasOne(StudentPaymentsData::class);
    }

}
