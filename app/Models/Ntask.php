<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa una tarea en el sistema.
 * 
 * Este modelo permite gestionar tareas que pueden ser asociadas a diferentes 
 * entidades, incluyendo su título, descripción, fecha, hora y tipo.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $ntaskable_id ID de la entidad asociada a la tarea.
 * @property string $ntaskable_type Tipo de la entidad asociada (ej. Project, Issue).
 * @property string $title Título de la tarea.
 * @property string $description Descripción de la tarea.
 * @property string $date Fecha de la tarea.
 * @property string $time Hora de la tarea.
 * @property string $type Tipo de tarea.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Ntask extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['ntaskable_id','ntaskable_type','title','description','date','time','type'];
    /**
     * Relacion polimorfica uno a muchos inversa  .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function ntaskable(){
        return $this->morphTo();
    } 
    /**
     * Relación polimórfica uno a muchos con los enlaces asociados a la tarea.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function links(){
        return $this->morphMany('App\Models\Link', 'linkable');
    }
    /**
     * Relación polimorfica uno a muchos (Entities-Images).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
     /**
     * Relación polimorfica uno a muchos (Entities-Icon).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
     public function icons(){
        return $this->morphMany('App\Models\Icon','iconable');
    }
   /**
     * Relación polimorfica uno a mucho (Entities-File).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files(){
        return $this->morphMany('App\Models\File','fileable');
    }
    /**
     * Relación polimorfica uno a muchos (Status-Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function statuses(){
        return $this->morphToMany('App\Models\Status','statusable');
    } 
    /**
     * Relación polimorfica de muchos a muchos (Status-Usuarios).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
     public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    }
    /**
     * Relacion morfeable uno a muchos (Project-delivery-assigned_activity-ntasks--quality_indicators).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function quality_indicators(){
        return $this->morphMany('App\Models\Quality_indicator','quality_indicable');
    }
}
