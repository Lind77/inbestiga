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
}
