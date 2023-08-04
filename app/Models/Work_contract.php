<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work_contract extends Model
{
    use HasFactory;
    protected $fillable = ['clausule', 'salary','type','status','user_id'];

    //relacion uno a uno inverso user-work_contract
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    //relacion uno a muchos work_contract-clausules
   public function clausules(){
    return $this->hasMany('App\Models\Clausule');
   }
}





