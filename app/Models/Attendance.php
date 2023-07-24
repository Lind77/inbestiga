<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date', 'first_punch', 'last_punch','weekday'];
    //Relacion uno a muchos inversa User-Attendance
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
