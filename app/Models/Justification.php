<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    use HasFactory;
    protected $fillable = ['miss_date', 'miss_time_admission', 'miss_time_departure', 'reason','status','user_id','time_amount','left_time'];
    //Relación  uno a muchos inverso attendances-Attendance-permit
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    //Relación uno a muchos Attendance_permit-Recovery_dates
    public function recovery_dates(){
        return $this->hasMany('App\Models\Recovery_date');
    }
}
