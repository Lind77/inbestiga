<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    protected $fillable=['code','title','description','date'];
    //Relacion uno a muchos (Version-Changes)
    public function changes(){
        return $this->hasMany('App\Models\Change');
    }
    //Relacion polimorfica Change-Images
     public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
}
