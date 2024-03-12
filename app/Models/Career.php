<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Relacion muchos a muchos Degree_career
    public function degrees()
    {
        return $this->belongsToMany("App\Models\Degree", 'career_degree');
    }
}
