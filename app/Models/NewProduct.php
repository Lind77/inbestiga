<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProduct extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'mode'];

    public function newprices(){
        return $this->hasMany('App\Models\NewPrice');
    }
}
