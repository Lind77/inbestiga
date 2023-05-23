<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunication extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'first_management', 'last_management', 'next_management', 'comment', 'product_tentative', 'type','time','atended'];

    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }
}
