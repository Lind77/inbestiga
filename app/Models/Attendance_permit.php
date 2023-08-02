<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_permit extends Model
{
    use HasFactory;
    protected $fillable= ['status','attendance_id','miss_date','miss_time','recovery_date','recovery_time','reason'];
    //Relación  uno a muchos inverso attendances-Attendance-permit
    public function attendance(){
     return $this->belongsTo('App\Models\Attendance');
    }
}
