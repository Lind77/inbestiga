<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un subtema dentro de un subtema más grande.
 *
 * Este modelo se utiliza para gestionar los subtemas y su relación
 * con temas y notas específicas.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único del subtema.
 * @property string $title Título del subtema.
 * @property string $description Descripción del subtema.
 * @property string $status Estado del subtema (activo, inactivo, etc.).
 * @property int $subtopic_id Identificador del subtema al que pertenece.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Subsub_topic extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['title','description','status','subtopic_id'];
     /**
     * Relación inversa uno a muchos Subtopic-Subsub_topic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subtopic(){
        return $this->belongsTo('App\Models\Subtopic');
    }
    /**
     * Relación uno a muchos Subsub_topic-Specific_topic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specific_topics(){
       return $this->hasMany('App\Models\Specific_topic');
    }
    /**
     * Relación polimorfica uno a muchos (Issue-Subtopics-Subsub_topic-Specific_topics).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes(){
        return $this->morphMany('App\Models\Note', 'noteable');
    }
    /**
     * Relación uno a muchos polimorfico Subsubtopic- Assigned_activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function assigned_activities(){
        return $this->morphMany('App\Models\Assigned_activity', 'assigned_activitiable');
    }
     /**
     * Relación polimórfica morfeable uno a muchos (Assigned_Activity-NOTES-NTASK).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
     public function ntasks(){
        return $this->morphMany('App\Models\Ntask', 'ntaskable');
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
}