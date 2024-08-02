<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpe extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    //Relacion uno a muchos Cpe-External-voucher
    public function external_vouchers(){
    return $this->hasMany('App\Models\External_voucher');    
    }
}
