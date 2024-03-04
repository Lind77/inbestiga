<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'date', 'amount', 'expiration_date', 'discount', 'term', 'note', 'status', 'attitude', 'interest'];
    //Relacion inersa muchos a muhos customer-quotation
    public function customers()
    {
        return $this->belongsToMany("App\Models\Customer", 'customer_quotation');
    }
    //Relación uno a muchos Quotation-Details
    public function details()
    {
        return $this->hasMany("App\Models\Detail");
    }
    // Relacion uno a uno Quotation-Order
    public function order()
    {
        return $this->hasOne("App\Models\Order");
    }
    // Relacion uno a uno Quotation-Contract
    public function contract()
    {
        return $this->hasOne("App\Models\Contract");
    }
    //Realcion muchos a muchos user-customer-comissions
    public function comissions()
    {
        return $this->hasMany("App\Models\Comission");
    }
    //Relacion morfeable uno a muchos (O-C-PAYMENT)
    public function payments(){
        return $this->morphMany('App\Models\Payment', 'paymentable');
    }
}
