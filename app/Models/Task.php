<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id', 'type','title', 'status', 'owner', 'start_time', 'end_time', 'fixed_task_id'];

    public function activity(){
        return $this->belongsTo('App\Models\Activity');
    }

    public function progress(){
        return $this->morphOne('App\Models\Progress', 'progressable');
    }

    public function projects(){
        return $this->belongsToMany("App\Models\Project");
    }

    public function fixed_task(){
        return $this->belongsTo("App\Models\FixedTask");
    }
}
