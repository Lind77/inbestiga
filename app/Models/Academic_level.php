<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_level extends Model
{
    use HasFactory;
    protected $fillable=['name','category_id'];
    //Relacion muchos  a muchos academic_product-academic_level
    public function academic_products(){
        return $this->belongsToMany('App\Models\Academic_product','academic_level_academic_product');
    }
    //Relación inversa uno a muchos Category-Project
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    //Relacion uno a muchos Category-Projects
    public function projects(){
        return $this->hasMany('App\Models\Project');
    }
}
