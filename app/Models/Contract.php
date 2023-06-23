<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['quotation_id', 'amount','amount_text','date', 'advance','percentage','third_article','fifth_article'];

    //Relacion inversa uno  a uno Contract-Quotation
    public function quotation(){
        return $this->belongsTo('App\Models\Quotation');
    }
      //Relacion morfeable uno a muchos (O-C-PAYMENT)
      public function payments(){
        return $this->morphMany('App\Models\Payment','paymentable');
    }
    //Relacion morfeable uno a muchos order,contract-project
    public function projects(){
        return $this->morphMany('App\Models\Project','projectable');
    }
    //Relacion polimorfica uno a mucho addendum-order-contract
    public function addendums(){
        return $this->morphMany('App\Models\Addendum','addendumable');
    }
}
