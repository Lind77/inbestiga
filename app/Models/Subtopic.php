<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtopic extends Model
{
    use HasFactory;
    protected $fillable=['title','description','status','issue_id'];
    //Relacion uno a muchos inversa Issue-Subtopics
    public function issue(){
        return $this->belongsTo('App\Models\Issue');
    }
    //Relcion uno a muchos Subtopic-Subsub_topic
    public function subsub_topics(){
        return $this->hasMany('App\Models\Subsub_topic');
    }
    //Relacion polimorfica uno a muchos (Issue-Subtopics-Subsub_topic-Specific_topics)
    public function notes(){
        return $this->morphMany('App\Models\Note', 'noteable');
    }
    //Relación uno a muchos polimorfico Subtopic- Assigned_activity
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
}
