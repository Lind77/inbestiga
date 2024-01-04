<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memorandum extends Model
{
    use HasFactory;
    protected $fillable=['emisor_id','receptor_id','subject','content','status','date','expiration_date','type','total_amount','code'];
    //Relación uno a muchos inversa User(receptor)-Memorandum
    public function emisor(){
        return $this->belongsTo('App\Models\User','emisor_id');
    }
    //Relación uno a muchos inversa User(emisor)-Memorandum
    public function receptor(){
        return $this->belongsTo('App\Models\User','receptor_id');
    }
    //Relacion uno a muchos Memorandum-Memorandum_details
    public function memorandum_details(){
        return $this->hasMany('App\Models\Memorandum_detail');
    }
    
}
