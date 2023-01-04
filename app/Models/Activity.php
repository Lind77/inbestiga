<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'title'];

    public function tasks(){
        return $this->belongsToMany("App\Models\Task")->withPivot('percent','comment');
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
