<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_permit extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'attendance_id', 'miss_date', 'miss_time_admission', 'miss_time_departure', 'reason', 'time_amount', 'left_time', 'user_id'];
    //Relación  uno a muchos inverso attendances-Attendance-permit
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    //Relación uno a muchos Attendance_permit-Recovery_dates
    public function recovery_dates()
    {
        return $this->morphMany('App\Models\Recovery_date', 'recoverable');
    }
}
    /*  //Relacion morfeable uno a muchos (Justification-Attendance_permits-Recovery_dates)
    public function recovery_dates()
    {
        return $this->morphMany('App\Models\Recovery_date','recoverable');
    }
}
