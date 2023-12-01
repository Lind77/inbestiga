<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recovery_date extends Model
{
    use HasFactory;
    protected $fillable = ['recovery_date','admission_time', 'departure_time','amount_recovered','attendance_permit_id','status','recoverable_id','recoverable_type'];
    //Realcion  inversa uno a muchos User-Schedule
    public function attendance_permit(){
        return $this->belongsTo('App\Models\Attendance_permit');
    }
    //Relación polimorfica uno a muchos Justification-Attendance_permit-Recoverydate
    public function recoverable(){
        return $this->morphTo();
    }
}
