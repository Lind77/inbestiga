<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_product extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    //Relacion muchos a muchos academic_product-academic_levels
    public function academic_levels(){
        return $this->belongsToMany('App\Models\Academic_level','academic_level_academic_product');
    }
    //Relacion muchos a muchos academic_produts-acceptance_indicators
    public function acceptance_indicators(){
        return $this->belongsToMany('App\Models\Acceptance_indicator','aproduct_aindicator');
    }   
    //Relación muchos a muchos inversa academic_process_academic_product
    public function academic_processes(){
        return $this->belongsToMany('App\Models\Academic_process','academic_process_academic_product');
    }
}
