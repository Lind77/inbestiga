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
    protected $fillable = ['name', 'email', 'password', 'subarea_id', 'team_id','calendly_user','color'];

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
    //Relacion uno a muchos User-Attendance_permits
    public function attendance_permits(){
        return $this->hasMany('App\Models\Attendance_permit');
    }
    //Relacion uno a muchos User-Justifications
    public function justifications(){
        return $this->hasMany('App\Models\Justification');
    }
    //relacion uno a uno user-work_contract
    public function work_contract(){
        return $this->hasOne('App\Models\Work_contract');
    }
    //relacion uno a uno user-applications
    public function documents(){
        return $this->hasMany('App\Models\Document');
    }    
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function statuses(){
         return $this->morphedByMany('App\Models\Status','userable');
    }
     //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
     public function issues(){
        return $this->morphedByMany('App\Models\Issue','userable');
   }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    // ya se ha creado esta relacion mas arriba pero no es polimorfica
    public function projects(){
        return $this->morphedByMany('App\Models\Project','userable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function notes(){
    return $this->morphedByMany('App\Models\Note','userable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function deliveries(){
        return $this->hasMany('App\Models\Delivery');
    }
   /*  //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function assigned_activities(){
        return $this->morphedByMany('App\Models\Assigned_activity','userable');
    } */
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function ntasks(){
        return $this->morphedByMany('App\Models\Ntask','userable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function subtopics(){
        return $this->morphedByMany('App\Models\Subtopic','userable');
    }
     //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
     public function subsub_topics(){
        return $this->morphedByMany('App\Models\Subsub_topic','userable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function specific_topics(){
        return $this->morphedByMany('App\Models\Specific_topic','userable');
    }
    //Relación uno a muchos user-memorandum
    public function memorandums(){
        return $this->hasMany('App\Models\Memorandum');
    }
     //Relación polimorfica uno a muchos (Entities-Images)
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
    //Relación uno a muchos user-Assigned_activities
    public function assigned_activities(){
        return $this->hasMany('App\Models\Assigned_activity');
    }
    //Relación polimorfica uno a muchos (User-Customer-Post)
    public function posts(){
        return $this->morphMany('App\Models\Post','postable');
    }
    //relación uno a uno user-contract
    public function contracts(){
        return $this->hasMany('App\Models\Contract');
    }
}
