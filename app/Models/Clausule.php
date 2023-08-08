<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clausule extends Model
{
    use HasFactory;
    protected $fillable = ['title','description ','work_contract_id'];
    //Relación inversa  de uno a muchos work_contract_Clausule
    public function work_contract(){
        return $this->belongsTo('App\Models\Work_contract');
    }
}
