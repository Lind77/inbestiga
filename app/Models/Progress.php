<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = ['progressable_id','progressable_type','user_id','percentage','start_time', 'end_time','comment'];
    //Relacion morfeable uno  a muchos Projec,delivery-assignedactivity,assignedtask-Progress
    public function progressable(){
        return $this->morphTo();
    }
    //Relacion uno a muchos inversa user-progress
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
