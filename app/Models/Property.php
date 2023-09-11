<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable=['propertiable_id','propertiable_type','properties'];
    //Relacion inversa polimorfica 
    public function propertiable(){
        return $this->morphTo();
    }
}
