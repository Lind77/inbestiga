<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_permit extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'attendance_id', 'miss_date', 'miss_time_admission', 'miss_time_departure', 'recovery_date', 'recovery_time_admission', 'recovery_time_departure', 'reason', 'user_id'];
    //Relación  uno a muchos inverso attendances-Attendance-permit
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
