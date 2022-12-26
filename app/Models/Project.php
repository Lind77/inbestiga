<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title','owner_id','status','deadline'];

    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }

    public function owner(){
        return $this->belongsTo("App\Models\Owner");
    }

    public function progress(){
        return $this->hasMany("App\Models\Progress");
    }
}
