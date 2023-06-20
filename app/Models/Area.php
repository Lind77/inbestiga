<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

      //Realcion uno a muchos Area-User
      public function users(){
        return $this->hasMany('App\Models\User');
        }
}
