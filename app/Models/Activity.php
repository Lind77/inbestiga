<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'title'];

    public function tasks(){
        return $this->hasMany("App\Models\Task");
    }
}
