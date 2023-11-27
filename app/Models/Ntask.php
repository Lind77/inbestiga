<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ntask extends Model
{
    use HasFactory;
    protected $fillable=['ntaskable_id','ntaskable_type','title','description','date','time','type'];

    //Relacion polimorfica uno a muchos inversa  
    public function ntaskable(){
        return $this->morphTo();
    } 
    public function links(){
        return $this->morphMany('App\Models\Link', 'linkable');
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
        return $this->morphMany('App\Models\File','fileable');
    }
}
