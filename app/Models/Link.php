<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable=['linkable_id','linkable_type','url'];
    //relacion polimorfica uno a muchos inversa Entities-Links
     public function linkable(){
        return $this->morphTo();
    }     
}
