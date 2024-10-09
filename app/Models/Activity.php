<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una Actividad.
 * 
 * Este modelo está relacionado con productos, tareas y niveles (relación polimórfica).
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $product_id
 * @property string $title
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Activity extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['product_id', 'title', 'type'];


       /**
     * Relación inversa uno a muchos entre Product y Activity.
     * 
     * Cada actividad pertenece a un producto.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo('App\Models\product');
    }
       /**
     * Relación uno a muchos entre Activity y Task.
     * 
     * Una actividad puede tener varias tareas asociadas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     public function tasks(){
        return $this->hasMany('App\Models\Task');
    }
    
    /**
     * Relación polimórfica muchos a muchos entre Activity y Level.
     * 
     * Las actividades pueden estar relacionadas con niveles a través de una relación polimórfica.
     * La relación se define usando la tabla `levelable`.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
     public function levels(){
        return $this->morphToMany('App\Models\Level','levelable');
    }
}
