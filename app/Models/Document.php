<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable=['title','description','type','user_id'];
    //Relación inversa de uno a muchos user-document
    public function user(){
     return $this->belongsTo('App\Models\User');
    }
}
