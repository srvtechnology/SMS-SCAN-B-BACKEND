<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
        'phone',
        'gender',
        'address',
        'permanent_address',
        'dob',
        'admission_date',
        'created_by',
        'is_deleted'
    ];

    public function fees()
    {
        return $this->belongsTo(StudentFeeStructure::class,'id','student_id');
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }

    public function assignClasses()
    {
        return $this->hasMany(StudentClassAssign::class, 'student_id');
    }

    public function getAllParents()
    {
        return $this->belongsTo(Parents::class,'parent_id');
    }
}
