<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable=['fileable_id','fileable_type','url'];
    //relacion polimorfica uno a muchos inversa Entities-Files
    public function fileable(){
        return $this->morphTo();
    }    
}
