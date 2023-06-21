<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['paymentable_id', 'paymentable_type','date','amount', 'advance', 'percentage'];
    //Relacion polimorfica
    public function paymentable(){
        return $this->morphTo();
    }  
}
