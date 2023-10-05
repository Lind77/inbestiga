<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memorandum_detail extends Model
{
    use HasFactory;
    protected $fillable=['title','content'];
    //Relación inversa uno a muchos Memorandum-Memorandum_detail
    public function memorandum(){
        return $this->belongsTo('App\Models\Memorandum');
    }
    //Relación polimorfica uno a muchos (Entities-Images)
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
}
