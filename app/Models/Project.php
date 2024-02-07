<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['projectable_id','projectable_type','title', 'team_id','user_id', 'status', 'deadline','academic_date','aditional','academic_level_id'];

    //Relacion  inversa morfeable uno a muchos order,contract-project
    public function projectable(){
        return $this->morphTo();
    }
    //Relacion inversa  uno a muchos Team-project
    public function team(){
        return $this->belongsTo("App\Models\Team");
    }
    //Relacion inversa  uno a muchos user-project
    public function user(){
        return $this->belongsTo("App\Models\Team");
    }
    //Relación uno a muchos Project_Delivery
    public function deliveries(){
        return $this->hasMany("App\Models\Delivery");
    }
    //Relacion muchos a muchos project_startupactivity
    public function startup_activities(){
        return $this->belongsToMany("App\Models\Startup_activity",'project_startup_activity');
    }
    //relacion uno a muchos morfeable morfeable(project,delivery,assigned_task,assigned_activity)
    public function progress(){
        return $this->morphMany('App\Models\Progress','progressable');
    }
    //relacion muchos amuchos morfeable_qualityindicators_(project,delivery,assigned_task,assigned_activity)
    public function quality_indicators(){
        return $this->morphToMany('App\Models\Quality_indicator','quality_indicable');
    }
    //Relacion morfeable uno a muchos project,deliveris,assigned_activities,assigned_task)
    public function observations(){
        return $this->morphMany('App\Models\Observation','observable');
    }
    //Relación polimorfica uno a muchos (Status-Entities)
    public function statuses(){
        return $this->morphToMany('App\Models\Status','statusable');
    }   
    //Relación polimorfica de muchos a muchos (Status-Usuarios)
     public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
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
    //Relación inversa uno a muchos Category-Project
    public function academic_level(){
        return $this->belongsTo('App\Models\Academic_level');
    }
}