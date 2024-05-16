<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_process extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    //Relación muchos a muchos academic-process/academic-products
    public function academic_products(){
        return $this->belongsToMany('App\Models\Academic_product','academic_process_academic_product');
    }
    //Relaci+on uno a muchos Academic_process-Academic_process
    public function assigned_activities(){
       return $this->hasMany('App\Models\Assigned_activity'); 
    }
}
