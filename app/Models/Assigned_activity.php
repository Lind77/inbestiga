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
    //Relación muchos a muchos polimorfica (status)-(entidades)(Project,Deliveries,Assigned_activities,Ntasks)
     public function statuses(){
        return $this->morphToMany('App\Models\Status','statusable');
    }
    //Relación polimorfica de muchos a muchos (Status-Usuarios)
    public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    }
    //Relacion morfeable uno a muchos (Assigned_Activity-NOTES-NTASK)
     public function ntasks(){
        return $this->morphMany('App\Models\Ntask', 'ntaskable');
    }
    public function links(){
        return $this->morphMany('App\Models\Links', 'linkable');
    }
    //Relación polimorfica uno a muchos (Entities-Images)
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
     //Relación polimorfica uno a muchos (Entities-Icon)
     public function icons(){
        return $this->morphMany('App\Models\Icon','iconable');
    }
    //Relación polimorfica uno a mucho (Entities-File)
    public function files(){
        return $this->mophMany('App\Models\File','fileable');        
    }

}
