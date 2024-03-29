<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = ['quotation_id','name', 'product_id', 'description', 'type', 'price', 'extra_price', 'level', 'mode'];

    //Relacion inversa uno a muchos Quotation detil
    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }
    //Relacion inversa uno a uno Product-Detail
    public function product()
    {
        return $this->belongsTo("App\Models\Product");
    }
}
