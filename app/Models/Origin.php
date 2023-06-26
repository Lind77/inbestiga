<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'type', 'channel', 'user_id'];

    //Relacion inversa uno a uno customer-origin
    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }



}
