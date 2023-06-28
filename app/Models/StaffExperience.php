<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffExperience extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'staff_id',
        'from_date',
        'to_date',
        'instituation',
    ];
}
