<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree_modality extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Relacion uno a muchos Degree-modality-contract
    public function contracts()
    {
        return $this->hasMany('App\Models\Contract');
    }
    
}
