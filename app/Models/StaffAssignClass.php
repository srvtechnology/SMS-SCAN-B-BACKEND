<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAssignClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'staff_id',
        'class_id',
        'section_id'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class,'id','section_id');
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class,'id','staff_id');
    }
}
