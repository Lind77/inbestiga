<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un detalle de un memorándum en el sistema.
 * 
 * Este modelo permite gestionar información específica sobre
 * un memorándum, incluyendo su contenido y detalles asociados.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $title Título del detalle del memorándum.
 * @property string $content Contenido del detalle del memorándum.
 * @property float $partial_amount Monto parcial asociado al detalle.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Memorandum_detail extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['title','content','partial_amount'];
    /**
     * Relación inversa uno a muchos Memorandum-Memorandum_detail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function memorandum(){
        return $this->belongsTo('App\Models\Memorandum');
    }
    /**
     * Relación polimorfica uno a muchos (Entities-Images).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
}
