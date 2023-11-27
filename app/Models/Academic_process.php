<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_process extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    //Relación uno a muchos Academci_process-Academic_product
    public function academic_products(){
        return $this->hasMany('App\Models\Academic_product');
    }
}
