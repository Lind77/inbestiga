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
    //relación muchos a muchos Bank_account-Payment_method
    public function bank_accounts(){
        return $this->belongsToMany("App\Models\Bank_account", 'bank_account_payment_method');
    }
}
