<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'date', 'amount'];

    public function order()
    {
        return $this->belongsTo("App\Models\Order");
    }
}
