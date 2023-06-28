<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'name',
        'status',
        'created_by',
        'is_deleted',
    ];

    public function assignedClasses()
    {
        return $this->hasMany(ClassAssignSection::class, 'section_id');
    }
}
