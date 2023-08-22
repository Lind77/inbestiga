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

}