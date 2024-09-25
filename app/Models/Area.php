<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un Área.
 * 
 * Este modelo está relacionado con subáreas, sedes (headquarters) y roles. 
 * También maneja jerarquías mediante la propiedad `father_id`.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $hierarchy
 * @property int|null $father_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Area extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','hierarchy','father_id'];

      /**
     * Relación uno a muchos entre Area y Subarea.
     * 
     * Un área puede tener múltiples subáreas asociadas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
      public function subareas(){
        return $this->hasMany('App\Models\Subarea');
        }
      /**
     * Relación muchos a muchos entre Area y Headquarter.
     * 
     * Un área puede estar asociada a múltiples sedes (headquarters) a través de la tabla pivote `area_headquarter`.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
     public function headquarters(){
        return $this->belongsToMany('App\Models\Headquarter','area_headquarter');
     }
        /**
     * Relación polimórfica uno a muchos entre Area y Role.
     * 
     * Un área puede tener múltiples roles asociados mediante una relación polimórfica.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
     public function roles()
     {
         return $this->morphMany('\Spatie\Permission\Models\Role', 'roleable');
     }
}
