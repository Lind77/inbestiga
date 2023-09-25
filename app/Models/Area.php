<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

      //Realcion uno a muchos Area-Subarea
      public function subareas(){
        return $this->hasMany('App\Models\Subarea');
        }
      //Relación inversa de headquarters-Areas
      public function headquarter(){
        return $this->belongsTo('App\Models\Headquarter');
      }
}
