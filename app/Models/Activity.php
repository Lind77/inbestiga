<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'title', 'type'];

    public function tasks(){
        return $this->hasMany("App\Models\Task");
    }

    public function progress(){
        return $this->morphMany('App\Models\Progress', 'progressable');
    }

    public function projects(){
        return $this->belongsToMany("App\Models\Project");
    }

    public function products(){
        return $this->belongsToMany("App\Models\Product");
    }
}
