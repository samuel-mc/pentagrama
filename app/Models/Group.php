<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function age() {
        return $this->belongsTo(Age::class);
    }

    public function studentsGroup() {
        return $this->hasMany(StudentsGroup::class, 'id_group');
    }

    public function schedules() {
        return $this->hasMany(Schedule::class);
    }
}
