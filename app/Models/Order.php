<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['quotation_id', 'final_delivery', 'observations', 'suggested'];

    //Relacion inversa uno  a uno Order-Quotation
    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }
    //Relacion morfeable uno a muchos (O-C-PAYMENT)
    public function payments()
    {
        return $this->morphMany('App\Models\Payment', 'paymentable');
    }

    //Relacion morfeable uno a muchos order,contract-deliveries
    public function deliveries()
    {
        return $this->morphMany('App\Models\Delivery', 'deliverable');
    }
    //Relacion polimorfica uno a mucho addendum-order-contract
    public function addendums()
    {
        return $this->morphMany('App\Models\Addendum', 'addendumable');
    }
}
