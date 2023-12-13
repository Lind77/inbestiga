<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable=['noteable_id','noteable_type','title','description','date','time'];
    //Relación polimorfica uno a muchos inversa notes-(issue-subtopics-subsub_topics-specific-topics)
    public function noteable(){
    return $this->morphTo();
    }  
    //4 relación polimorfica que la mayoria de las entidades deben de tener
    //Relacion polimorfica uno a muchos (Entities-links)
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
     //Relación polimorfica de muchos a muchos (Status-Usuarios)
     public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    }
    //Relación polimorfica uno a muchos (Status-Entities)
    public function statuses(){
        return $this->morphToMany('App\Models\Status','statusable');
    }   
    //Relacion morfeable uno a muchos (Assigned_Activity-NOTES-NTASK)
    public function ntasks(){
        return $this->morphMany('App\Models\Ntask', 'ntaskable');
    }
}
