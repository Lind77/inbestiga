<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'date', 'link', 'comment'];
   //relacion polimorfica muchos a muchos 
   public function users(){
    return $this->morphedByMany('App\Models\User','meetingable');
   }
      //relacion polimorfica muchos a muchos 
      public function customers(){
        return $this->morphedByMany('App\Models\Customer','meetingable');
       }
}
