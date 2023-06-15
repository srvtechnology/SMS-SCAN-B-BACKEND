<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_by',
        'user_id',
        'username',
        'name',
        'email',
        'password',
        'contact_number',
        'landline_number',
        'affilliation_number',
        'board',
        'type',
        'medium',
        'address',
        'image'
    ];
}
