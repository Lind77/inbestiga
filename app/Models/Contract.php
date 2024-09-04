<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['quotation_id', 'amount', 'amount_text', 'cent_text', 'date', 'advance', 'percentage', 'third_article', 'third_article_place', 'status', 'fifth_article', 'third_article_ppts', 'fragment', 'user_id', 'bank_account_type', 'degree_modality_id'];

    //Relacion inversa uno  a uno Contract-Quotation
    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }
    //Relacion morfeable uno a muchos (O-C-PAYMENT)
    public function payments()
    {
        return $this->morphMany('App\Models\Payment', 'paymentable');
    }
    //Relacion polimorfica uno a mucho addendum-order-contract
    public function addendums()
    {
        return $this->morphMany('App\Models\Addendum', 'addendumable');
    }
    //Relacion morfeable uno a muchos (orders-contracts-payments-payment_proofs)
    public function payment_proofs()
    {
        return $this->morphMany('App\Models\Payment_proof', 'payment_proofable');
    }
    //Relacion morfeable uno a muchos (O-C-Projects)
    public function projects()
    {
        return $this->morphMany('App\Models\Project', 'projectable');
    }
    //Relación polimorfica uno a mucho (Contrato-Orden->Properties())
    public function properties()
    {
        return $this->morphMany('App\Models\Property', 'propertiable');
    }
    //relación uno a muchos Contract-External_voucher
    public function external_vouchers()
    {
        return $this->hasMany('App\Models\External_voucher');
    }
    //relación uno a uno user-contract inversa
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    //Relacion inversa uno a muchos Degree-modality-Contract
    public function degree_modality()
    {
        return $this->belongsTo('App\Models\Degree_modality');
    }
}
