<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public function assignedSections()
    {
        return $this->hasMany(ClassAssignSection::class, 'class_id');
    }
}
