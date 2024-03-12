<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Relacion muchos a muchos university_faculties
    public function faculties(){
        return $this->belongsToMany("App\Models\Faculty", 'faculty_university');
    }
}
