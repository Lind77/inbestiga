<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_situation extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //relación uno a muchos 
     public function forms(){
        return $this->hasMany("App\Models\Form");
    }
    //relación uno a muchos 
    public function properties(){
        return $this->hasMany("App\Models\Property");
    }
}
