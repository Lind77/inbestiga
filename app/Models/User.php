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
    protected $fillable = ['name', 'email', 'password', 'subarea_id', 'team_id'];

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
    //Realcion uno a muchos User-Schedule
    public function schedules(){
        return $this->hasMany('App\Models\Schedule');
    }
    //Realcion inversa uno a mucho Subarea-User
    public function subarea(){
        return $this->belongsTo('App\Models\Subarea');
    }
    //realcion muchos a muchos user-notifications
    public function notifications()
    {
        return $this->belongsToMany('App\Models\Notification', 'seens');
    }
    //realcion polimorfica muchos a muchos user-meetings
    public function meetings()
    {
        return $this->morphToMany('App\Models\Meeting', 'meetingable');
    }
    //relacion uno a muchos user-comissions
    public function comissions()
    {
        return $this->hasMany('App\Models\Comission');
    }
    //Relacion uno muchos user-Customers
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
    //Relacion uno a muchos User-Project
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
    //Relacion uno a muchos User-Progress
    public function progress()
    {
        return $this->hasMany('App\Models\Progress');
    }
    //relacion uno a muchos user-comissions
    public function attendances()
    {
        return $this->hasMany('App\Models\Attendance');
    }
}
