<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'area_id','father_id','heirarchy'];

  //Realcion inversa uno a muchos Area-Subarea
  public function area()
  {
    return $this->belongsTo('App\Models\Area');
  }
  //Realcion uno a muchos Subarea-User
  public function users()
  {
    return $this->hasMany('App\Models\User');
  }
  //Relación polimorficaa uno a muchos dasdas as
  public function roles()
  {
    return $this->hasMany('\Spatie\Permission\Models\Role');
  }
  /* //Relación uno a muchos polimorfica 
  public function roles()
  {
      return $this->morphMany('\Spatie\Permission\Models\Role', 'roleable');
  } */
}
