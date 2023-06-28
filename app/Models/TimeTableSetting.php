<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTableSetting extends Model
{
    use HasFactory;

    public function fromClass()
    {
        return $this->belongsTo(Classes::class,'from_class');
    }

    public function toClass()
    {
        return $this->belongsTo(Classes::class,'to_class');
    }
}
