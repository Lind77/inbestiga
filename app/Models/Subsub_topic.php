<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsub_topic extends Model
{
    use HasFactory;
    protected $fillable=['title','description','status','subtopic_id'];
    //relacion inversa uno a muchos Subtopic-Subsub_topic
    public function subtopic(){
        return $this->belongsTo('App\Models\Subtopic');
    }
    //relacion uno a muchos Subsub_topic-Specific_topic
    public function specific_topics(){
       return $this->hasMany('App\Models\Specific_topic');
    }
    //Relacion polimorfica uno a muchos (Issue-Subtopics-Subsub_topic-Specific_topics)
    public function notes(){
        return $this->morphMany('App\Models\Note', 'noteable');
    }
    //Relación uno a muchos polimorfico Subsubtopic- Assigned_activity
    public function assigned_activities(){
        return $this->morphMany('App\Models\Assigned_activity', 'assigned_activitiable');
    }
     //Relacion morfeable uno a muchos (Assigned_Activity-NOTES-NTASK)
     public function ntasks(){
        return $this->morphMany('App\Models\Ntask', 'ntaskable');
    }
     //Relación polimorfica uno a muchos (Entities-Images)
     public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
    //Relación polimorfica uno a muchos (Status-Entities)
    public function statuses(){
        return $this->morphToMany('App\Models\Status','statusable');
    }   
     //Relación polimorfica de muchos a muchos (Status-Usuarios)
     public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    }
}