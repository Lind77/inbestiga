<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una nota en el sistema.
 * 
 * Este modelo permite gestionar notas que pueden estar asociadas a diferentes
 * entidades dentro del sistema, como problemas, subtemas y otros.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $noteable_id ID de la entidad a la que pertenece la nota.
 * @property string $noteable_type Tipo de la entidad a la que pertenece la nota.
 * @property string $title Título de la nota.
 * @property string $description Descripción de la nota.
 * @property \Illuminate\Support\Carbon $date Fecha de creación de la nota.
 * @property string $time Hora de creación de la nota.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Note extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['noteable_id','noteable_type','title','description','date','time'];
     /**
     * Relación polimorfica uno a muchos inversa notes-(issue-subtopics-subsub_topics-specific-topics).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function noteable(){
    return $this->morphTo();
    }  
     /**
     * 4 relación polimorfica que la mayoria de las entidades deben de tener Relación polimórfica uno a muchos con los enlaces asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function links(){
        return $this->morphMany('App\Models\Links', 'linkable');
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
        return $this->mophMany('App\Models\File','fileable');        
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
     *Relación polimorfica uno a muchos (Status-Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function statuses(){
        return $this->morphToMany('App\Models\Status','statusable');
    }   
    /**
     * Relacion morfeable uno a muchos (Assigned_Activity-NOTES-NTASK).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ntasks(){
        return $this->morphMany('App\Models\Ntask', 'ntaskable');
    }
}
