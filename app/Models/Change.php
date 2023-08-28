<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    use HasFactory;
    protected $fillable=['code','title','description'];
    //Relación uno a muchos inversa Version-Change
    public function version(){
        return $this->belongsTo('App\Models\Version');
    }
    //Relacion polimorfica Change-Images
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
}
