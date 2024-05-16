<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['postable_id', 'postable_type','title','body', 'project_id'];
    
    //Relación polimorfica inversa uno a muchos CUSTOMER-USER-POST
    public function postable(){
        return $this->morphTo();
    }
    //Relación polimorfica inversa uno a muchos 
    public function project(){
        return $this->belongsTo('App\Models\Project');
    }
}
