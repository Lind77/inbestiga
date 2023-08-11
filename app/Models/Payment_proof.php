<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_proof extends Model
{
    use HasFactory;
    protected $fillable = ['payment_proofable_id', 'payment_proofable_type', 'customer_id', 'code', 'date', 'subtotal', 'tax', 'discount', 'total_price', 'type', 'remaining_amount', 'pay_detail'];
    //Relacion uno a muchos payment_proofs-proof_details
    public function proof_details()
    {
        return $this->hasMany('App\Models\Proof_detail');
    }
    //Relacion polimorfica uno a muchos unversa payments_(módulo de venta d eproductos o cursos online)-payment_proofs
    public function payment_proofable()
    {
        return $this->morphTo();
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
