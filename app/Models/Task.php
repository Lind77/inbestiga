<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id','title'];

    //Realcion inversa uno a mucho Product-Activity
    public function activity(){
        return $this->belongsTo('App\Models\Activity');
    }
    //Realcion polimorficaa muchos a muchos (P-A-T-LEVELS)
    public function levels(){
        return $this->morphToMany('App\Models\Level','levelable');
    }

   
}
