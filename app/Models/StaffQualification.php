<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffQualification extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'staff_id',
        'year',
        'education',
        'instituation'
    ];
}
