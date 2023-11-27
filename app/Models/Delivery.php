<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['deliverable_id', 'deliverable_type', 'date', 'academic_date', 'advance', 'progress', 'type', 'status', 'project_id'];
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
    //Relación uno a muchos polimorfico Delivery - Assigned_activity
    public function assigned_activities()
    {
        return $this->morphMany('App\Models\Assigned_activity', 'assigned_activitiable');
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
    //Relación muchos a muchos polimorfica (status)-(entidades)(Project,Deliveries,Assigned_activities,Ntasks)
    public function statuses()
    {
        return $this->morphToMany('App\Models\Status', 'statusable');
    }
    //Relación polimorfica de muchos a muchos (Status-Usuarios)
    public function users()
    {
        return $this->morphToMany('App\Models\User', 'userable');
    }
    public function links()
    {
        return $this->morphMany('App\Models\Links', 'linkable');
    }
    //Relación polimorfica uno a muchos (Entities-Images)
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
    //Relación polimorfica uno a muchos (Entities-Icon)
    public function icons()
    {
        return $this->morphMany('App\Models\Icon', 'iconable');
    }
    //Relación polimorfica uno a mucho (Entities-File)
    public function files()
    {
        return $this->mophMany('App\Models\File', 'fileable');
    }

    public function deliverable()
    {
        return $this->morphTo();
    }
}
