<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTablePeriod extends Model
{
    use HasFactory;

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function timetablesetting()
    {
        return $this->belongsTo(TimeTableSetting::class,'time_table_setting_id');
    }
}
