<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Relación uno a muchos Payment_method-voucher
    public function external_vouchers(){
        return $this->hasMany('App\Models\External_voucher');    
    }
}
