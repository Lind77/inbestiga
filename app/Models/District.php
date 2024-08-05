<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['name','province_id','department_id'];
    //Relacion inversa uno amuchos Department-Province
    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
    //Relación inversa uno a muchos Department-District
     public function department()
     {
         return $this->belongsTo('App\Models\Department');
     }
}
