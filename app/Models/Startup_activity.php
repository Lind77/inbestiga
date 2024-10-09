<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una actividad inicial (Startup Activity).
 *
 * Este modelo se utiliza para gestionar la información sobre actividades iniciales 
 * que pueden estar asociadas a múltiples proyectos.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único de la actividad inicial.
 * @property string $name Nombre de la actividad inicial.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Startup_activity extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name']; 
    /**
     * Relación muchos a muchos project_startupactivity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects(){
        return $this->belongsToMany('App\Models\Project','project_startup_activity');
    }
}
