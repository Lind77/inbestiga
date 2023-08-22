<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;
    protected $fillable=['iconable_id','iconable_type','class'];
    //relacion polimorfica uno a muchos inversa Entities-Icons
     public function iconable(){
        return $this->morphTo();
    }    
}
