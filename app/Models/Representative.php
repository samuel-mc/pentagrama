<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function howFoundUs()
    {
        return $this->belongsTo(HowFoundUs::class);
    }
}
