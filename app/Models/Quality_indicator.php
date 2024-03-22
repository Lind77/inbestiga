<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quality_indicator extends Model
{
    use HasFactory;
    protected $fillable = ['quality_indicable_id','quality_indicable_type','name','observation','status'];
    /* //Relacion polimorfica muchos a muchos (project,delivery,assigned activty,assigned_task)
    public function projects(){
        return $this->morphedByMany('App\Models\Project','quality_indicable');
    }
    //Relacion polimorfica muchos a muchos (project,delivery,assigned activty,assigned_task)
    public function deliveries(){
        return $this->morphedByMany('App\Models\Delivery','quality_indicable');
    }
    //Relacion polimorfica muchos a muchos (project,delivery,assigned activty,assigned_task)
    public function assigned_activities(){
        return $this->morphedByMany('App\Models\Assigned_activity','quality_indicable');
    }
    //Relacion polimorfica muchos a muchos (project,delivery,assigned activty,assigned_task)
    public function assigned_tasks(){
        return $this->morphedByMany('App\Models\Assigned_task','quality_indicable');
    } */
    //Relación uno a muchos (projects_deliveries_assigned-activities-ntasks===Quality_indicators)
    public function quality_indicable(){
        return $this->morphTo();
    }    
}
