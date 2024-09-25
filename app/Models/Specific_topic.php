<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un tema específico dentro de un subtema.
 *
 * Este modelo se utiliza para gestionar la información sobre temas específicos,
 * incluyendo su relación con subtemas, notas, actividades asignadas y otros 
 * elementos polimórficos asociados.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único del tema específico.
 * @property string $title Título del tema específico.
 * @property string $description Descripción del tema específico.
 * @property bool $status Estado del tema específico (activo o inactivo).
 * @property int $subsub_topic_id ID del subsubtema asociado.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Specific_topic extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['title','description','status','subsub_topic_id'];
     /**
     * Relación uno a muchos inversa Subsub_topic-Specific_topic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subsub_topic(){
      return $this->belongsTo('App\Models\Subsub_topic');  
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
     * Relación uno a muchos polimorfico Specifictopic - Assigned_activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
  public function assigned_activities(){
    return $this->morphMany('App\Models\Assigned_activity', 'assigned_activitiable');
  }
   /**
     * Relacion morfeable uno a muchos (Assigned_Activity-NOTES-NTASK).
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
