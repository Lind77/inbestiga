<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un Cambio.
 * 
 * Este modelo gestiona la información de los cambios realizados,
 * incluyendo su código, título y descripción, así como las imágenes asociadas.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Change extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['code','title','description'];
    /**
     * Relación uno a muchos inversa Version-Change.
     * 
     * Un cambio pertenece a una versión específica.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function version(){
        return $this->belongsTo('App\Models\Version');
    }
    /**
     * Relacion polimorfica Change-Images.
     * 
     * Un cambio puede tener múltiples imágenes asociadas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
}
