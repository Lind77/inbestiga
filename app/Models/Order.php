<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['quotation_id', 'final_delivery', 'observations', 'suggested'];

    //Relacion inversa uno  a uno Order-Quotation
    public function quotation(){
        return $this->belongsTo('App\Models\Quotation');
    }
    //Relacion morfeable uno a muchos (O-C-PAYMENT)
    public function payments(){
        return $this->morphMany('App\Models\Payment', 'paymentable');
    }
    //Relacion morfeable uno a muchos (O-C-PROJECTS)
     public function projects(){
        return $this->morphMany('App\Models\Project', 'projectable');
    }
    //Relacion polimorfica uno a mucho addendum-order-contract
    public function addendums(){
        return $this->morphMany('App\Models\Addendum', 'addendumable');
    }
   //Relacion morfeable uno a muchos (orders-contract-payments-payment_proofs)
   public function payment_proofs(){
    return $this->morphMany('App\Models\Payment_proof', 'payment_proofable');
   }
   //Relación polimorfica uno a mucho (Contrato-Orden->Properties())
   public function properties(){
    return $this->morphMany('App\Models\Property', 'propertiable');
}
}
