<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un proyecto.
 *
 * Este modelo gestiona la información y las relaciones asociadas a un proyecto,
 * incluyendo su estado, fechas, y las actividades relacionadas.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $projectable_id ID del modelo asociado al proyecto.
 * @property string $projectable_type Tipo del modelo asociado al proyecto.
 * @property string $title Título del proyecto.
 * @property int $team_id ID del equipo asociado al proyecto.
 * @property int $user_id ID del usuario asociado al proyecto.
 * @property string $status Estado del proyecto.
 * @property string $start_date Fecha de inicio del proyecto.
 * @property string $deadline Fecha límite del proyecto.
 * @property string $academic_date Fecha académica del proyecto.
 * @property string $aditional Información adicional sobre el proyecto.
 * @property int $academic_level_id ID del nivel académico del proyecto.
 * @property string $type Tipo del proyecto.
 * @property string $complexity Complejidad del proyecto.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Project extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['projectable_id', 'projectable_type', 'title', 'team_id', 'user_id', 'status', 'start_date', 'deadline', 'academic_date', 'aditional', 'academic_level_id', 'type', 'complexity'];
    /**
     * Relacion  inversa morfeable uno a muchos order,contract-project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function projectable()
    {
        return $this->morphTo();
    }
    /**
     * Relacion inversa  uno a muchos Team-project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo("App\Models\Team");
    }
    /**
     * Relacion inversa  uno a muchos user-project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
    /**
     * Relación uno a muchos Project_Delivery.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries()
    {
        return $this->hasMany("App\Models\Delivery");
    }
    /**
     * Relación uno a muchos Project_Post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany("App\Models\Post");
    }
    /**
     * Relacion muchos a muchos project_startupactivity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function startup_activities()
    {
        return $this->belongsToMany("App\Models\Startup_activity", 'project_startup_activity');
    }
    /**
     * Relacion uno a muchos morfeable morfeable(project,delivery,assigned_task,assigned_activity).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function progress()
    {
        return $this->morphMany('App\Models\Progress', 'progressable');
    }
    /* //relacion muchos amuchos morfeable_qualityindicators_(project,delivery,assigned_task,assigned_activity)
    public function quality_indicators()
    {
        return $this->morphToMany('App\Models\Quality_indicator', 'quality_indicable');
    } */
    /**
     * Relacion morfeable uno a muchos (Project-delivery-assigned_activity-ntasks--quality_indicators).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function quality_indicators()
    {
        return $this->morphMany('App\Models\Quality_indicator', 'quality_indicable');
    }
    /**
     * Relacion morfeable uno a muchos project,deliveris,assigned_activities,assigned_task)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function observations()
    {
        return $this->morphMany('App\Models\Observation', 'observable');
    }
    /**
     * Relación polimorfica uno a muchos (Status-Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function statuses()
    {
        return $this->morphToMany('App\Models\Status', 'statusable');
    }
    /**
     * Relación polimorfica de muchos a muchos (Status-Usuarios).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function users()
    {
        return $this->morphToMany('App\Models\User', 'userable');
    }
    /**
     * Relación polimórfica uno a muchos entre Project y Links.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function links()
    {
        return $this->morphMany('App\Models\Links', 'linkable');
    }
    /**
     * Relación polimorfica uno a muchos (Entities-Images).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
    /**
     * Relación polimorfica uno a muchos (Entities-Icon).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function icons()
    {
        return $this->morphMany('App\Models\Icon', 'iconable');
    }
    /**
     * Relación polimorfica uno a mucho (Entities-File).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany('App\Models\File', 'fileable');
    }
    /**
     * Relación inversa uno a muchos Category-Project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function academic_level()
    {
        return $this->belongsTo('App\Models\Academic_level');
    }
}
