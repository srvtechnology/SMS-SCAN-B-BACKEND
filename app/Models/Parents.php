<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;
    protected $table = 'parents';

    // public function allParents()
    // {
    //     return $this->hasMany(Parents::class,'id','parent_id');
    // }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
