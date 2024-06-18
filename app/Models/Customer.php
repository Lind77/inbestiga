<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['name', 'password', 'cell', 'dni', 'address', 'university', 'career', 'status', 'email', 'user_id', 'origin', 'time', 'needs', 'interest', 'attitude', 'userregister_id', 'birth_date', 'type'];


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
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    //realcion polimorfica muchos a muchos user-meetings
    public function meetings()
    {
        return $this->morphToMany('App\Models\Meeting', 'meetingable');
    }
    //relación uno a muchos Customer-External_voucher
    public function external_vouchers()
    {
        return $this->hasMany('App\Models\External_voucher');
    }
    //Relación polimorfica uno a muchos (User-Customer-Post)
    public function posts()
    {
        return $this->morphMany('App\Models\Post', 'postable');
    }
}
