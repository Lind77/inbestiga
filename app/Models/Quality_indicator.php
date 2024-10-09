<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un indicador de calidad en un sistema de gestión de proyectos.
 *
 * Este modelo gestiona la información relacionada con los indicadores de calidad
 * y su relación con diferentes entidades como proyectos, entregas, actividades
 * asignadas y tareas asignadas.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $quality_indicable_id ID del modelo al que pertenece el indicador de calidad.
 * @property string $quality_indicable_type Tipo del modelo al que pertenece el indicador de calidad.
 * @property string $name Nombre del indicador de calidad.
 * @property string|null $observation Observaciones adicionales sobre el indicador.
 * @property string|null $status Estado del indicador de calidad.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Quality_indicator extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['quality_indicable_id','quality_indicable_type','name','observation','status'];
    /* //Relacion polimorfica muchos a muchos (project,delivery,assigned activty,assigned_task)
    public function projects(){
        return $this->morphedByMany('App\Models\Project','quality_indicable');
    }
    //Relacion polimorfica muchos a muchos (project,delivery,assigned activty,assigned_task)
    public function deliveries(){
        return $this->morphedByMany('App\Models\Delivery','quality_indicable');
    }
    //Relacion polimorfica muchos a muchos (project,delivery,assigned activty,assigned_task)
    public function assigned_activities(){
        return $this->morphedByMany('App\Models\Assigned_activity','quality_indicable');
    }
    //Relacion polimorfica muchos a muchos (project,delivery,assigned activty,assigned_task)
    public function assigned_tasks(){
        return $this->morphedByMany('App\Models\Assigned_task','quality_indicable');
    } */
       /**
     * Relación uno a muchos (projects_deliveries_assigned-activities-ntasks===Quality_indicators).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function quality_indicable(){
        return $this->morphTo();
    }    
}
