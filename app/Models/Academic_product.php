<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_product extends Model
{
    use HasFactory;
    protected $fillable=['name','academic_process_id'];
    //Relacion muchos a muchos academic_product-academic_levels
    public function academic_levels(){
        return $this->belongsToMany('App\Models\Academic_level','academic_level_academic_product');
    }
    //Relacion muchos a muchos academic_produts-acceptance_indicators
    public function acceptance_indicators(){
        return $this->belongsToMany('App\Models\Acceptance_indicator','aproduct_aindicator');
    }
    //Relación uno a muchos inversa Academic_process-Academic_product
    public function academic_process(){
        return $this->belongsTo('App\Models\Academic_process');
    }
}
