<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'team_id', 'customer_id', 'product_id', 'status', 'deadline', 'level'];

    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }

    public function team(){
        return $this->belongsTo("App\Models\Team");
    }

    public function activities(){
        return $this->hasMany("App\Models\Activity");
    }

    public function tasks(){
        return $this->belongsToMany("App\Models\Task");
    }

    public function progresses(){
        return $this->hasMany("App\Models\Progress");
    }

    public function product(){
        return $this->belongsTo("App\Models\Product");
    }
}
