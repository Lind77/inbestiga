<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['deliverable_id', 'deliverable_type', 'date', 'academic_date', 'advance', 'progress', 'type', 'status'];
    //Relacion inversa uno amuchos Project-Delivery
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    //relacion muchos amuchos morfeable_qualityindicators_(project,delivery,assigned_task,assigned_activity)
    public function quality_indicators()
    {
        return $this->morphToMany('App\Models\Quality_indicator', 'quality_indicable');
    }
    //Relación uno a muchos Project_Delivery
    public function assigned_activities()
    {
        return $this->hasMany("App\Models\Assigned_activity");
    }
    //relacion uno a muchos morfeable morfeable(project,delivery,assigned_task,assigned_activity)
    public function progress()
    {
        return $this->morphMany('App\Models\Progress', 'progressable');
    }
    //Relacion morfeable uno a muchos project,deliveris,assigned_activities,assigned_task)
    public function observations()
    {
        return $this->morphMany('App\Models\Observation', 'observable');
    }
    //Relacion polimorfica
    public function deliverable()
    {
        return $this->morphTo();
    }
}
