<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proof_detail extends Model
{
    use HasFactory;
    protected $fillable = ['payment_proof_id','product_name','price','level','amount'];
    //Relacion uno a muchos inversa payment_proofs-proof_details
    public function payment_proof(){
     return $this->belongsTo('App\Models\Payment_proof');
    }
}
