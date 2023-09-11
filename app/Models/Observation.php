<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;
    protected $fillable = ['observable_id', 'observable_type', 'content', 'status'];

    //Relacion polimorfica inversa uno a muchos
    public function observable()
    {
        return $this->morphTo();
    }
}
