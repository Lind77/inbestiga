<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'date', 'link', 'comment'];
    //realcion muchos a muchos user-meetings
    public function users(){
        return $this->belongsToMany('App\Models\User', 'meeting_user');
    }
}
