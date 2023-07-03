<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTimeSheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id','exam_id','class_id','subject_id','date','start_time','end_time','is_deleted','created_by'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
