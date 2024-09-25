<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una observación en el sistema.
 * 
 * Este modelo permite gestionar observaciones que pueden estar asociadas 
 * a diferentes entidades, incluyendo su contenido y estado.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $observable_id ID de la entidad asociada a la observación.
 * @property string $observable_type Tipo de la entidad asociada (ej. Issue, Task).
 * @property string $content Contenido de la observación.
 * @property string $status Estado de la observación.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Observation extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['observable_id', 'observable_type', 'content', 'status'];
     /**
     * Relacion polimorfica inversa uno a muchos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function observable()
    {
        return $this->morphTo();
    }
}
