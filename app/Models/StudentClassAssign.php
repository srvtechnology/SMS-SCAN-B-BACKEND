<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClassAssign extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
