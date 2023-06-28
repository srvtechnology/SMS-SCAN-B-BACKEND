<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'name',
        'status',
        'created_by',
        'is_deleted',
    ];
}
