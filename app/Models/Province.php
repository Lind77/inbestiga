<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable = ['name','department_id'];
    //Relacion inversa uno amuchos Department-Province
    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
    // Relación uno a muchos province-district´
    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }
    //relación uno a muchos province-customer
    public function customers(){
        return $this->hasMany('App\Models\Customer');
    }
}
