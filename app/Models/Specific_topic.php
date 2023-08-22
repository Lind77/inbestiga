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
}
