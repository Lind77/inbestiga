<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['paymentable_id', 'paymentable_type','date','amount', 'advance', 'percentage'];
    //Relacion polimorfica uno a muchos inversa contract_orders-payments
    public function paymentable(){
        return $this->morphTo();
    }  
    //Relacion morfeable uno a muchos (payments-payment_proofs)
    public function payment_proofs(){
        return $this->morphMany('App\Models\Payment_proof', 'payment_proofable');
    }
}
