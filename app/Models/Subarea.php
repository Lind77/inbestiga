<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    //Realcion inversa uno a muchos Area-Subarea
    public function area(){
      return $this->belongsTo('App\Models\Area');
      }
      //Realcion uno a muchos Subarea-User
      public function users(){
        return $this->hasMany('App\Models\User');
        }
}
