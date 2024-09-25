<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un problema o incidencia en el sistema.
 * 
 * Este modelo gestiona la información relacionada con los problemas,
 * permitiendo crear relaciones con subtemas, notas, usuarios y otros 
 * elementos relevantes.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Issue extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['title','description','status'];
    /**
     * Relacion de uno a muchos Issue-Subtopics.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subtopics(){
        return $this->hasMany('App\Models\Subtopic');
    }
    /**
     * Relacion polimorfica uno a muchos (Issue-Subtopics-Subsub_topic-Specific_topics).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes(){
        return $this->morphMany('App\Models\Note', 'noteable');
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
     * Relación uno a muchos polimorfico Delivery - Assigned_activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */

    public function assigned_activities()
    {
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
}
