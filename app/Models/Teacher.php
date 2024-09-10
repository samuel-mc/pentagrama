<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function groups() {
        return $this->hasMany(Group::class);
    }

    public function timeSlots() {
        return $this->hasMany(TimeSlotByTeacher::class);
    }
}
