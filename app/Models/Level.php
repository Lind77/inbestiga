<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    //Realcion polimorficaa muchos a muchos (P-A-T-LEVELS)
    public function products(){
        return $this->morphedByMany('App\Models\Product','levelable');
    }
    public function activities(){
        return $this->morphedByMany('App\Models\Activity','levelable');
    }
    public function tasks(){
        return $this->morphedByMany('App\Models\Task','levelable');
    }
}
