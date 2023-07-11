<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'user_id',
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
        'phone',
        'gender',
        'designation_id',
        'address',
        'salary',
        'joining_date',
        'additional_documents',
        'fb_profile',
        'insta_profile',
        'linkedIn_profile',
        'twitter_profile',
        'created_by',
        'is_deleted'
    ];

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function qualifications()
    {
        return $this->hasMany(StaffQualification::class,'staff_id');
    }

    public function experiences()
    {
        return $this->hasMany(StaffExperience::class,'staff_id');
    }

    public function classes()
    {
        return $this->hasMany(StaffAssignClass::class,'staff_id')->OrderBy('class_id','asc');
    }

    public function subjects()
    {
        return $this->hasMany(StaffAssignSubject::class,'staff_id');
    }

    public function assign_class_teacher_class()
    {
        return $this->belongsTo(Classes::class,'assign_class_to_class_teacher','id');
    }

    public function assign_class_teacher_section()
    {
        return $this->belongsTo(Section::class,'assign_section_to_class_teacher','id');
    }
}
