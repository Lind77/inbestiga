<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specific_topic extends Model
{
    use HasFactory;
    protected $fillable=['title','description','status','subsub_topic_id'];
    //relación uno a muchos inversa Subsub_topic-Specific_topic
    public function subsub_topic(){
      return $this->belongsTo('App\Models\Subsub_topic');  
    }
    //Relación polimorfica uno a muchos (Issue-Subtopics-Subsub_topic-Specific_topics)
    public function notes(){
      return $this->morphMany('App\Models\Note', 'noteable');
  }
  //Relación uno a muchos polimorfico Specifictopic - Assigned_activity
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
