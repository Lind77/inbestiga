<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'title', 'type'];


    //Realcion inversa uno a mucho Product-Activity
    public function product(){
        return $this->belongsTo('App\Models\product');
    }
    //Realcion uno a mucho Activity-Task
     public function tasks(){
        return $this->hasMany('App\Models\Task');
    }
    //Realcion polimorficaa muchos a muchos (P-A-T-LEVELS)
     public function levels(){
        return $this->morphToMany('App\Models\Level','levelable');
    }
}
