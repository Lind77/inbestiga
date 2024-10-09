<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una propiedad dentro de un sistema de gestión de proyectos.
 *
 * Este modelo gestiona la información relacionada con las propiedades de diferentes
 * entidades, así como su estado dentro de una situación de proyecto.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $propertiable_id ID de la entidad relacionada (puede ser un proyecto, entrega, etc.).
 * @property string $propertiable_type Tipo de entidad a la que pertenece la propiedad.
 * @property string $properties Propiedades asociadas.
 * @property bool $documentary_processing Indica si el procesamiento documental está en curso.
 * @property int $project_situation_id ID de la situación del proyecto asociada.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Property extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['propertiable_id', 'propertiable_type', 'properties', 'documentary_processing', 'project_situation_id'];
    /**
     * Relacion inversa polimorfica.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */ 
    public function propertiable()
    {
        return $this->morphTo();
    }
    /**
     * Relación polimorfica inversa uno a muchos project_situation-property.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project_situation()
    {
        return $this->belongsTo('App\Models\Project_situation');
    }
}
