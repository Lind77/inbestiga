<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un Proceso Académico.
 * 
 * Este modelo está relacionado con productos académicos y actividades asignadas.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class Academic_process extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name'];
      /**
     * Relación muchos a muchos entre Academic_process y Academic_product.
     * 
     * Esta función establece la relación entre procesos académicos y productos académicos
     * a través de la tabla pivote `academic_process_academic_product`.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function academic_products(){
        return $this->belongsToMany('App\Models\Academic_product','academic_process_academic_product');
    }
     /**
     * Relación uno a muchos entre Academic_process y Assigned_activity.
     * 
     * Un proceso académico puede tener muchas actividades asignadas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assigned_activities(){
       return $this->hasMany('App\Models\Assigned_activity'); 
    }
}
