<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['name','hierarchy','father_id'];

      //Realcion uno a muchos Area-Subarea
      public function subareas(){
        return $this->hasMany('App\Models\Subarea');
        }
     //Relación muchos a muchos Area-Headquarter
     public function headquarters(){
        return $this->belongsToMany('App\Models\Headquarter','area_headquarter');
     }
     //Relación uno a muchos polimorfica 
     public function roles()
     {
         return $this->morphMany('\Spatie\Permission\Models\Role', 'roleable');
     }
}
