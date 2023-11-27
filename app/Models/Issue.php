<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;
    protected $fillable=['title','description','status'];
    //relacion de uno a muchos Issue-Subtopics
    public function subtopics(){
        return $this->hasMany('App\Models\Subtopic');
    }
    //Relacion polimorfica uno a muchos (Issue-Subtopics-Subsub_topic-Specific_topics)
    public function notes(){
        return $this->morphMany('App\Models\Note', 'noteable');
    }
    //Relación polimorfica de muchos a muchos (Status-Usuarios)
    public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    }
    //Relación uno a muchos polimorfico Delivery - Assigned_activity
    public function assigned_activities()
    {
        return $this->morphMany('App\Models\Assigned_activity', 'assigned_activitiable');
    }
     //Relacion morfeable uno a muchos (Assigned_Activity-NOTES-NTASK)
     public function ntasks(){
        return $this->morphMany('App\Models\Ntask', 'ntaskable');
    }
}
