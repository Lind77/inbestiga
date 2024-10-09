<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una tarea dentro de una actividad.
 *
 * Este modelo se utiliza para gestionar las tareas y su relación
 * con actividades y niveles.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único de la tarea.
 * @property int $activity_id Identificador de la actividad a la que pertenece la tarea.
 * @property string $title Título de la tarea.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Task extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['activity_id','title'];
    /**
     * Relación inversa uno a mucho Product-Activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity(){
        return $this->belongsTo('App\Models\Activity');
    }
    /**
     * Relación polimorfica muchos a muchos (P-A-T-LEVELS).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function levels(){
        return $this->morphToMany('App\Models\Level','levelable');
    }

   
}
