<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    use HasFactory;
    protected $fillable = ['miss_date', 'admission_time', 'departure_time', 'reason','status','user_id'];
    //Relación  uno a muchos inverso User_Justifications
    public function  user(){
        return $this->belongsTo('App\Models\User');
    }
}
