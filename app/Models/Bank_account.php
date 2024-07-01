<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank_account extends Model
{
    use HasFactory;
    protected $fillable = ['account_number','account_holder','type','bank_entity_id','cci'];
    //Relación inversa uno a muchos bank_entity-bank_account
    public function bank_entity(){
        return $this->belongsTo('App\Models\Bank_entity');
    }
    //relación uno a muchos Customer-External_voucher
    public function external_vouchers(){
        return $this->hasMany('App\Models\External_voucher');
    }
    //relación muchos a muchos Bank_account-Payment_method
    public function payment_methods(){
        return $this->belongsToMany("App\Models\Payment_method", 'bank_account_payment_method');
    }
}
