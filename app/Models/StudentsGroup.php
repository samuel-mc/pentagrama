<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsGroup extends Model
{
    use HasFactory;

    public function group() {
        return $this->belongsTo(Group::class, 'id_group', 'id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'id_student', 'id');
    }
}
