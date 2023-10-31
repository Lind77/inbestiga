<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name','password' ,'cell', 'dni', 'address', 'university', 'career', 'status', 'email', 'user_id', 'origin', 'time', 'needs', 'interest', 'attitude'];


    //Relacion muchos a muchos Customer-Quotations
    public function quotations()
    {
        return $this->belongsToMany("App\Models\Quotation", 'customer_quotation');
    }
    //Relacion uno a muchos custoemr-comunications
    public function comunications()
    {
        return $this->hasMany("App\Models\Comunication");
    }
    //Relacion uno a muchos custoemr-origins
    public function origin()
    {
        return $this->hasOne("App\Models\Origin");
    }
    //Relacion uno a muchos user -customer
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    //realcion polimorfica muchos a muchos user-meetings
    public function meetings()
    {
        return $this->morphToMany('App\Models\Meeting', 'meetingable');
    }
}
