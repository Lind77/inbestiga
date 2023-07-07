<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = ['admission_time', 'departure_time', 'type', 'day', 'week'];
    //Realcion  inversa uno a muchos User-Schedule
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
