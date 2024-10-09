<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un nivel en el sistema.
 * 
 * Este modelo permite gestionar diferentes niveles que pueden ser
 * asociados a productos, actividades y tareas a través de relaciones
 * polimórficas.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Level extends Model
{
    use HasFactory;
      /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name']; 
    /**
     * Relación polimorficaa muchos a muchos (P-A-T-LEVELS).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function products(){
        return $this->morphedByMany('App\Models\Product','levelable');
    }
    /**
     * Relación polimórfica muchos a muchos con actividades.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function activities(){
        return $this->morphedByMany('App\Models\Activity','levelable');
    }
    /**
     * Relación polimórfica muchos a muchos con tareas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function tasks(){
        return $this->morphedByMany('App\Models\Task','levelable');
    }
}
