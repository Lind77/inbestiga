<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Startup_activity extends Model
{
    use HasFactory;
    protected $fillable = ['name']; 
    //Relacion muchos a muchos project_startupactivity
    public function projects(){
        return $this->belongsToMany("App\Models\Project")->with_pivot('project_startup_activity');
    }
}
