<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'date', 'amount','expiration_date','discount','term', 'note'];
    //Relacion inersa uno a muhos customer-quotation
    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }
    //Relación uno a muchos Quotation-Details
    public function details(){
        return $this->hasMany("App\Models\Detail");
    }
    // Relacion uno a uno Quotation-Order
    public function order(){
        return $this->hasOne("App\Models\Order");
    }
    // Relacion uno a uno Quotation-Contract
    public function contract(){
        return $this->hasOne("App\Models\Contract");
    }
}
