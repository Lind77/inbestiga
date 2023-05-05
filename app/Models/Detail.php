<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','quotation_id', 'type', 'description', 'price','new_product_id','level','mode'];

    public function product(){
        return $this->belongsTo("App\Models\Product");
    }

    public function new_product(){
        return $this->belongsTo("App\Models\NewProduct");
    }
}
