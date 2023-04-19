<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['emisor_id', 'content', 'type','extra'];

    public function users(){
        return $this->belongsToMany('App\Models\User','seens')->withPivot('id','seen');
    }

    public function emisor(){
        return $this->belongsTo('App\Models\User', 'emisor_id');
    }
}
