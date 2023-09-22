<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headquarter extends Model
{
    use HasFactory;
    protected $fillable=['name','address','company_id'];
    //Relación inversa uno a muchos  Company-Headquearters
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
    //Relación uno a muchos Headquarter-Areas
    public function areas(){
        return $this->hasMany('App\Models\Area');
    }
}
