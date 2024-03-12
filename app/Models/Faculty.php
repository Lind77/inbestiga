<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $fillable = ['name','team_id'];
    //Relacion muchos a muchos University-Faculty
    public function universities(){
        return $this->belongsToMany("App\Models\University", 'faculty_university');
    }
     //Relacion muchos a muchos faculty-degree  
     public function degrees()
     {
         return $this->belongsToMany("App\Models\Degree", 'degree_faculty');
     }
     //Relacion uno a muchos inversa team-career
    public function team(){
        return $this->belongsTo("App\Models\Team");
    }
}
