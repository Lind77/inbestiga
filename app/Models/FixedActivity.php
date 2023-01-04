<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title'
    ];

    public function fixedTasks(){
        return $this->hasMany('App\Models\FixedTask');
    }
}
