<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earn_type extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    //Relacion uno a muchos Earn_type-External-voucher
    public function external_vouchers(){
    return $this->hasMany('App\Models\External_voucher');    
    }
}
