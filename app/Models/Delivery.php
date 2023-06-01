<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'date', 'advance'];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }
}
