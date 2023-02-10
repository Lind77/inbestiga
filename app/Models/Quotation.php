<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'date', 'amount','expiration_date','discount'];

    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }
}
