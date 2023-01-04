<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;


    protected $fillable = ['activity_id', 'type','title'];

    public function activity(){
        return $this->belongsTo('App\Models\Activity');
    }

    public function progresses(){
        return $this->morphToMany('App\Models\Progress', 'progressable');
    }

    public function projects(){
        return $this->belongsToMany("App\Models\Project");
    }
}
