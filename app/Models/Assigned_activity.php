<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigned_activity extends Model
{
    use HasFactory;
    protected $fillable = ['assigned_activitiable_id', 'assigned_activitiable_type', 'name', 'start_date', 'end_date', 'type', 'progress', 'status', 'priority', 'user_id', 'points','academic_process_id','type','verified_date','complexity'];
    //relacion muchos amuchos morfeable_qualityindicators_(project,delivery,assigned_task,assigned_activity)
    /* public function quality_indicators()
    {
        return $this->morphToMany('App\Models\Quality_indicator', 'quality_indicable');
    } */
    //Relacion  inversa morfeable uno a muchos delivery-assigned activity
    public function assigned_activitiable()
    {
        return $this->morphTo();
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
    //Relación polimorfica uno a muchos (Status-Entities)
    public function statuses()
    {
        return $this->morphToMany('App\Models\Status', 'statusable');
    }
    /* //Relación polimorfica de muchos a muchos (Status-Usuarios)
     public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    } */
    //Relación inversa unoa a muchos (User-Assigned activity)
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    //Relación inversa uno a muchos  (users-assignedactivitiy)
    public function assigned_activity()
    {
        return $this->belongsTo('App\Models\User');
    }
    //Relacion morfeable uno a muchos (Assigned_Activity-NOTES-NTASK)
    public function ntasks()
    {
        return $this->morphMany('App\Models\Ntask', 'ntaskable');
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
    //Relacion morfeable uno a muchos (Project-delivery-assigned_activity-ntasks--quality_indicators)
    public function quality_indicators()
    {
        return $this->morphMany('App\Models\Quality_indicator', 'quality_indicable');
    }
    //Relación uno a muchos inversa Academic_process-Assisgned_activity
    public function academic_process(){
        return $this->belongsTo('App\Models\Academic_process');
    }
}
