<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Relacion uno a muchos Category-Projects
    public function projects(){
        return $this->hasMany('App\Models\Project');
    }
    //Relación uno a muchos Category-Icon
    public function icons(){
        return $this->morphMany('App\Models\Icon','iconeable');
    }
}
