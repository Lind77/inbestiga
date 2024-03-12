<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Relacion muchos a muchos university_degree
    public function faculties()
    {
        return $this->belongsToMany("App\Models\Faculty", 'degree_faculty');
    }
    //Relación muchos a muchos career_degree
    public function careers()
    {
        return $this->belongsToMany("App\Models\Career", 'career_degree');
    }
}
