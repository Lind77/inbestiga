<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigned_activity extends Model
{
    use HasFactory;
    protected $fillable = ['delivery_id','title', 'date', 'academic_date','type','progress','status'];
    //relacion muchos amuchos morfeable_qualityindicators_(project,delivery,assigned_task,assigned_activity)
    public function quality_indicators(){
        return $this->morphToMany('App\Models\Quality_indicator','quality_indicable');
    }
    //Relacion inversa uno amuchos Delivery-assigned_activity
    public function delivery() {
        return $this->belongsTo('App\Models\Delivery');
    }
    //Relación uno a muchos assigned_activities-assigned_tasks
      public function assigned_tasks(){
        return $this->hasMany("App\Models\Assigned_task");
    }
     //relacion uno a muchos morfeable morfeable(project,delivery,assigned_task,assigned_activity)
     public function progress(){
        return $this->morphMany('App\Models\Progress','progressable');
    }
    //Relacion morfeable uno a muchos project,deliveris,assigned_activities,assigned_task)
    public function observations(){
        return $this->morphMany('App\Models\Observation','observable');
    }
}
