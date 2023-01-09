<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = ['progressable_id','progressable_type','comment','percentage','owner','start_time'];

    public function activity(){
        return $this->morphedByMany('App\Models\Activity', 'progressable');
    }

    public function task(){
        return $this->morphedByMany('App\Models\Task', 'progressable');
    }
}
