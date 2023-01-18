<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memoir extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'team_id', 'area'];

    public function team(){
        return $this->belongsTo('App\Models\Team');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
