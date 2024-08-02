<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['name','province_id'];
    //Relacion inversa uno amuchos Department-Province
    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
}
