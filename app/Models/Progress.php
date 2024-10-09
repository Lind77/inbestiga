<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa el progreso de una tarea o actividad en el sistema.
 * 
 * Este modelo gestiona el seguimiento del progreso relacionado con proyectos,
 * entregas, actividades asignadas y tareas asignadas.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $progressable_id ID de la entidad relacionada con el progreso.
 * @property string $progressable_type Tipo de entidad relacionada (proyecto, entrega, etc.).
 * @property int $user_id ID del usuario que registra el progreso.
 * @property float $percentage Porcentaje de progreso.
 * @property string $start_time Hora de inicio del progreso.
 * @property string $end_time Hora de finalización del progreso.
 * @property string|null $comment Comentario adicional sobre el progreso.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Progress extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['progressable_id','progressable_type','user_id','percentage','start_time', 'end_time','comment'];
    /**
     * Relacion morfeable uno  a muchos Projec,delivery-assignedactivity,assignedtask-Progress.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function progressable(){
        return $this->morphTo();
    }
    /**
     * Relación uno a muchos inversa user-progress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
