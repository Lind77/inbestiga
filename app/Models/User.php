<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','email','password','area_id','team_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    
    //Realcion inversa uno a mucho Team-User
    public function team(){
        return $this->belongsTo('App\Models\Team');
    }
    //Realcion inversa uno a mucho Area-User
    public function area(){
        return $this->belongsTo('App\Models\Area');
    }
    //realcion muchos a muchos user-notifications
    public function notifications(){
        return $this->belongsToMany('App\Models\Notification','seens');
    }
    //relacion uno a muchos user-comissions
    public function comissions(){
        return $this->hasMany('App\Models\Comission');
    }
    //Relacion uno muchos user-Customers
    public function customers(){
        return $this->hasMany('App\Models\Customer');
    }
      //Relacion uno a muchos User-Project
      public function projects(){
        return $this->hasMany('App\Models\Project');
        }
    //Relacion uno a muchos UsER-Progress
    public function progress(){
        return $this->hasMany('App\Models\Progress');
    }
}
