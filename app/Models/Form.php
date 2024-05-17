<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable=['name','forms','project_situation_id'];
    //Relación polimorfica inversa uno a muchos project_situation-form 
    public function project_situation(){
        return $this->belongsTo('App\Models\Project_situation');
    }
}
