<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type', 'mode'];


    //Realcion uno a mucho Product-Activity
    public function Activities()
    {
        return $this->hasMany('App\Models\Activity');
    }
    //Realcion polimorficaa muchos a muchos (P-A-T-LEVELS)
    public function levels()
    {
        return $this->morphToMany('App\Models\Level', 'levelable')->withPivot('price');
    }
    //  Relación uno  a uno product-detail
    public function detail()
    {
        return $this->hasOne('App\Models\Detail');
    }
}
