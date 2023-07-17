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
        return $this->belongsToMany('App\Models\User', 'meeting_user','user_id','meeting_id');
    }
    //Relacion muchos a muchos customer_meetings
    public function customers(){
        return $this->belongsToMany('App\Models\Cusomer','meeting_user','customer_id','meeting_id');
    }
}
