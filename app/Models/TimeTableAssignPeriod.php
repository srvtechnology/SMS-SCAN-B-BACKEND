<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTableAssignPeriod extends Model
{
    use HasFactory;

    public function day_range()
    {
        return $this->belongsTo(TimetableSetting::class,'time_table_setting_id');
    }

    public function period()
    {
        return $this->belongsTo(TimetablePeriod::class,'time_table_period_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
