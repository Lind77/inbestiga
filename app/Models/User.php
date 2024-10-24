<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Modelo que representa a un usuario del sistema.
 *
 * Este modelo se utiliza para gestionar la información relacionada
 * con los usuarios, sus roles, y sus relaciones con otras entidades.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único del usuario.
 * @property string $name Nombre del usuario.
 * @property string $email Correo electrónico del usuario.
 * @property string $password Contraseña del usuario.
 * @property int|null $subarea_id Identificador de la subárea asociada al usuario.
 * @property int|null $team_id Identificador del equipo al que pertenece el usuario.
 * @property string|null $calendly_user Usuario de Calendly.
 * @property string|null $color Color asociado al usuario.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
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


     /**
     * Relación inversa uno a mucho Team-User
     *
     * Este método define la relación donde un usuario pertenece a un equipo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(){
        return $this->belongsTo('App\Models\Team');
    }
    /**
     * Relación uno a muchos User-Schedule.
     *
     * Este método define la relación donde un usuario puede tener múltiples horarios.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(){
        return $this->hasMany('App\Models\Schedule');
    }
      /**
     * Relación inversa uno a mucho Subarea-User.
     *
     * Este método define la relación donde un usuario pertenece a una subárea.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subarea(){
        return $this->belongsTo('App\Models\Subarea');
    }
     /**
     * Relacion morfeable uno a muchos (Customer-User-Notification).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications(){
        return $this->morphMany('App\Models\Notification', 'notificable');
    }
     /**
     * Relacion morfeable uno a muchos (User customer-Seen).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function seens(){
        return $this->morphMany('App\Models\Seen', 'seenable');
    }
     /**
     * Relación polimorfica muchos a muchos user-meetings.
     *
     * Este método define la relación donde un usuario puede participar en múltiples reuniones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function meetings()
    {
        return $this->morphToMany('App\Models\Meeting', 'meetingable');
    }
     /**
     * Relación uno a muchos user-comissions.
     *
     * Este método define la relación donde un usuario puede tener múltiples comisiones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comissions()
    {
        return $this->hasMany('App\Models\Comission');
    }
    /**
     * Relación uno muchos user-Customers.
     *
     * Este método define la relación donde un usuario puede tener múltiples clientes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
    /**
     * Relación uno a muchos User-Progress.
     *
     * Este método define la relación donde un usuario puede tener múltiples progresos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function progress()
    {
        return $this->hasMany('App\Models\Progress');
    }
     /**
     * Relación uno a muchos user-comissions.
     *
     * Este método define la relación donde un usuario puede tener múltiples asistencias.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances()
    {
        return $this->hasMany('App\Models\Attendance');
    }
    /**
     * Relación uno a muchos User-Attendance_permits.
     *
     * Este método define la relación donde un usuario puede tener múltiples permisos de asistencia.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendance_permits(){
        return $this->hasMany('App\Models\Attendance_permit');
    }
    /**
     * Relación uno a muchos User-Justifications.
     *
     * Este método define la relación donde un usuario puede tener múltiples justificaciones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function justifications(){
        return $this->hasMany('App\Models\Justification');
    }
     /**
     * Relación uno a uno user-work_contract.
     *
     * Este método define la relación donde un usuario puede tener un único contrato de trabajo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function work_contract(){
        return $this->hasOne('App\Models\Work_contract');
    }
     /**
     * Relación  uno a uno user-documents.
     *
     * Este método define la relación donde un usuario puede tener múltiples documentos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents(){
        return $this->hasMany('App\Models\Document');
    }    
      /**
     * Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
     *
     * Este método define la relación donde un usuario puede tener múltiples estados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function statuses(){
         return $this->morphedByMany('App\Models\Status','userable');
    }
     /**
     * Relación polimorfica uno a muchos (Usuario-(Status)(notes-)).
     *
     * Este método define la relación donde un usuario puede tener múltiples problemas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
     public function issues(){
        return $this->morphedByMany('App\Models\Issue','userable');
   }
    // ya se ha creado esta relacion mas arriba pero no es polimorfica
     /**
     * Relación polimorfica uno a muchos (Usuario-(Status)(notes-)).
     *
     * Este método define la relación donde un usuario puede estar involucrado en múltiples proyectos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function projects(){
        return $this->morphedByMany('App\Models\Project','userable');
    }
     /**
     * Relación polimorfica uno a muchos (Usuario-(Status)(notes-)).
     *
     * Este método define la relación donde un usuario puede tener múltiples notas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function notes(){
    return $this->morphedByMany('App\Models\Note','userable');
    }
    /**
     * Relación polimorfica uno a muchos (Usuario-(Status)(notes-)).
     *
     * Este método define la relación donde un usuario puede tener múltiples entregas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries(){
        return $this->hasMany('App\Models\Delivery');
    }
   /*  //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function assigned_activities(){
        return $this->morphedByMany('App\Models\Assigned_activity','userable');
    } */
    /**
     * Relación polimorfica uno a muchos (Usuario-(Status)(notes-)).
     *
     * Este método define la relación donde un usuario puede tener múltiples tareas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function ntasks(){
        return $this->morphedByMany('App\Models\Ntask','userable');
    }
      /**
     * Relación polimorfica uno a muchos (Usuario-(Status)(notes-)).
     *
     * Este método define la relación donde un usuario puede tener múltiples subtemas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
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
