<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class External_voucher extends Model
{
    use HasFactory;
    protected $fillable = ['operation_code','amount','payment_concept','date','status','observation','contract_id','customer_id','bank_account_id','payment_method_id','external_discount','internal_discount','partial_amount','taxes','net_profit'];
    //Relación uno a muchos inverso Payment_method-External_voucher
    public function payment_method(){
        return $this->belongsTo('App\Models\Payment_method');
    }
    //Relación uno a muchos inversa Customer-External_voucher
    Public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }
    //Relación inversa uno a muchos Contract-External_voucher
    public function contract(){
        return $this->belongsTo('App\Models\Contract');
    }
    //Relación inversa uno a muchos Bank_account-Contract
    public function bank_account(){
        return $this->belongsTo('App\Models\Bank_account');
    }
    //Relación inversa uno a muchos Bank_account-Contract
    public function cpe(){
        return $this->belongsTo('App\Models\Cpe');
    }
    //Relación inversa uno a muchos Bank_account-Contract
    public function earn_type(){
        return $this->belongsTo('App\Models\Earn_type');
    }
    //Relación polimorfica uno a muchos (Entities-Images)
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
    //Relacion morfeable uno a muchos (External_voucher-payments-payment_proofs)
    public function payment_proofs(){
         return $this->morphMany('App\Models\Payment_proof', 'payment_proofable');
    }
    
}
