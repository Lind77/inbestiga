<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa una Actividad Asignada.
 * 
 * Este modelo permite la asignación de actividades a diferentes entidades (proyectos, entregas, tareas, etc.) mediante relaciones polimórficas.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $assigned_activitiable_id
 * @property string $assigned_activitiable_type
 * @property string $name
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string $type
 * @property float $progress
 * @property string $status
 * @property string $priority
 * @property int $user_id
 * @property int $points
 * @property int $academic_process_id
 * @property \Illuminate\Support\Carbon|null $verified_date
 * @property string $complexity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Assigned_activity extends Model
{
    use HasFactory;
       /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['assigned_activitiable_id', 'assigned_activitiable_type', 'name', 'start_date', 'end_date', 'type', 'progress', 'status', 'priority', 'user_id', 'points','academic_process_id','type','verified_date','complexity'];
    //relacion muchos amuchos morfeable_qualityindicators_(project,delivery,assigned_task,assigned_activity)
    /* public function quality_indicators()
    {
        return $this->morphToMany('App\Models\Quality_indicator', 'quality_indicable');
    } */
     /**
     * Relación polimórfica inversa uno a muchos.
     * 
     * Permite que una actividad asignada pertenezca a diferentes entidades (proyecto, entrega, tarea, etc.).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function assigned_activitiable()
    {
        return $this->morphTo();
    }
     /**
     * Relación polimórfica uno a muchos para progreso.
     * 
     * Registra el progreso relacionado con diferentes entidades.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function progress()
    {
        return $this->morphMany('App\Models\Progress', 'progressable');
    }
     /**
     * Relación polimórfica uno a muchos para observaciones.
     * 
     * Registra observaciones sobre diferentes entidades.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function observations()
    {
        return $this->morphMany('App\Models\Observation', 'observable');
    }
      /**
     * Relación polimórfica uno a muchos para estados.
     * 
     * Define los estados relacionados con la entidad asignada.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function statuses()
    {
        return $this->morphToMany('App\Models\Status', 'statusable');
    }
    /* //Relación polimorfica de muchos a muchos (Status-Usuarios)
     public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    } */
     /**
     * Relación inversa uno a muchos con User.
     * 
     * Relaciona la actividad asignada con un usuario.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
      /**
     * Relación polimórfica uno a muchos para tareas (ntasks).
     * 
     * Define las tareas (ntasks) relacionadas con la actividad asignada.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ntasks()
    {
        return $this->morphMany('App\Models\Ntask', 'ntaskable');
    }
    /**
     * Relación polimórfica uno a muchos para enlaces.
     * 
     * Define los enlaces asociados con la actividad asignada.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function links()
    {
        return $this->morphMany('App\Models\Links', 'linkable');
    }
    /**
     * Relación polimórfica uno a muchos para imágenes.
     * 
     * Define las imágenes relacionadas con la actividad asignada.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
     /**
     * Relación polimórfica uno a muchos para íconos.
     * 
     * Define los íconos relacionados con la actividad asignada.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function icons()
    {
        return $this->morphMany('App\Models\Icon', 'iconable');
    }
     /**
     * Relación polimórfica uno a muchos para archivos.
     * 
     * Define los archivos relacionados con la actividad asignada.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->mophMany('App\Models\File', 'fileable');
    }
    /**
     * Relación polimórfica uno a muchos para indicadores de calidad.
     * 
     * Define los indicadores de calidad relacionados con la actividad asignada.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function quality_indicators()
    {
        return $this->morphMany('App\Models\Quality_indicator', 'quality_indicable');
    }
    /**
     * Relación inversa uno a muchos con Academic_process.
     * 
     * Relaciona la actividad asignada con un proceso académico.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function academic_process(){
        return $this->belongsTo('App\Models\Academic_process');
    }
}
