<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = ['comment','percentage'];

    public function activity(){
        return $this->belongsTo('App\Models\Activity');
    }

    public function task(){
        return $this->belongsTo('App\Models\Task');
    }
}
