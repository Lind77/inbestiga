<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date', 'discount','first_punch', 'last_punch','weekday','status','worked_time'];
    //Relacion uno a muchos inversa User-Attendance
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    //Relacion uno a muchos attendances-attendances_permits
    public function attendance_permits(){
        return $this->hasMany('App\Models\Attendance_permit');
    }
}
