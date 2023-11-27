<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acceptance_indicator extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    //relacion muchos a muchos academic_products-acceptance_indicators
    public function academic_products(){    
        return $this->belongsToMany('App\Models\Academic_product','aproduct_aindicator');
    }
}
