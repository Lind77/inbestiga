<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un equipo dentro del sistema.
 *
 * Este modelo gestiona los equipos y sus relaciones con usuarios,
 * proyectos y facultades.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único del equipo.
 * @property string $name Nombre del equipo.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Team extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
    /**
     * Relación uno a muchos Team-User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(){
    return $this->hasMany('App\Models\User');
    }
     /**
     * Relación uno a muchos Team-project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(){
        return $this->hasMany('App\Models\Project');
    }
     /**
     * Relación uno a muchos Team-Career.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     public function faculties()
     {
         return $this->hasMany("App\Models\Faculty");
     }
     /**
     * Relación polimorfica uno a muchos (Entities-Icons).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
     public function icons(){
        return $this->morphMany('App\Models\Icon','iconable');
    }
}
