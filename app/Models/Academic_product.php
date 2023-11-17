<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_product extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    public function academic_levels(){
        return $this->belongsToMany('App\Models\Academic_level','academic_level_academic_product');
    }
}
