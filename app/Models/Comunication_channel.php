<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunication_channel extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    public function post_forms()
    {
        return $this->hasMany('App\Models\Post_form');
    }
}
