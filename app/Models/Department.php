<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Relacion inversa uno amuchos Department-Province
    public function provinces()
    {
        return $this->hasMany('App\Models\Province');
    }
}
