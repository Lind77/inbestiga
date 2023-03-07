<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'type'
    ];

    public function fixedTasks(){
        return $this->hasMany('App\Models\FixedTask');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
}
