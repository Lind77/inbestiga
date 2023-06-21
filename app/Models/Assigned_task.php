<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigned_task extends Model
{
    use HasFactory;
    protected $fillable = ['assigned_activity_id','title', 'date', 'academic_date','type','progress','status'];
    //relacion muchos amuchos morfeable_qualityindicators_(project,delivery,assigned_task,assigned_activity)
    public function quality_indicators(){
        return $this->morphToMany('App\Models\Quality_indicator','quality_indicable');
    }
    //Relacion inversa uno amuchos assinged_activity-assigned_task
    public function assigned_activity() {
        return $this->belongsTo('App\Models\Assigned_activity');
    }
     //relacion uno a muchos morfeable morfeable(project,delivery,assigned_task,assigned_activity)
     public function progress(){
        return $this->morphMany('App\Models\Progress','progressable');
    }
    
}
