<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un estado (Status).
 *
 * Este modelo se utiliza para gestionar los estados que pueden estar asociados a 
 * diferentes entidades en la aplicación, como usuarios, proyectos y tareas.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único del estado.
 * @property string $name Nombre del estado.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Status extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name'];
    /**
     * Relación polimorfica de muchos a muchos (Status-Usuarios).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    }
    /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function notes(){
      return $this->morphedByMany('App\Models\Note','statusable');
    }
    /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function projects(){
        return $this->morphedByMany('App\Models\Project','statusable');
    }
    /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function deliveries(){
        return $this->morphedByMany('App\Models\Delivery','statusable');
    }
    /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function assigned_activities(){
        return $this->morphedByMany('App\Models\Assigned_activity','statusable');
    }
    /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function ntasks(){
        return $this->morphedByMany('App\Models\Ntask','statusable');
    }
    /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function issues(){
        return $this->morphedByMany('App\Models\Issue','statusable');
    }
    /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function subtopics(){
        return $this->morphedByMany('App\Models\Subtopic','statusable');
    }
     /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function subsub_topics(){
        return $this->morphedByMany('App\Models\Subsub_topic','statusable');
    }
     /**
     * Relación polimorfica uno a muchos (Status)-(Entities).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function specific_topics(){
        return $this->morphedByMany('App\Models\Specific_topic','statusable');
    }
}
