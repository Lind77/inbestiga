<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    //Realcion uno a muchos Team-User
    public function users(){
    return $this->hasMany('App\Models\User');
    }
    //Relacion uno a muchos Team-project
    public function projects(){
        return $this->hasMany('App\Models\Project');
    }
     //Relación uno a muchos Team-Career
     public function faculties()
     {
         return $this->hasMany("App\Models\Faculty");
     }
}
