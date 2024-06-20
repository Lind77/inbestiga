<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = ['propertiable_id', 'propertiable_type', 'properties', 'documentary_processing', 'project_situation_id'];
    //Relacion inversa polimorfica 
    public function propertiable()
    {
        return $this->morphTo();
    }
    //Relación polimorfica inversa uno a muchos project_situation-property
    public function project_situation()
    {
        return $this->belongsTo('App\Models\Project_situation');
    }
}
