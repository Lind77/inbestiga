<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un Producto Académico.
 * 
 * Este modelo está relacionado con niveles académicos, indicadores de aceptación y procesos académicos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Academic_product extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name'];
     /**
     * Relación muchos a muchos entre Academic_product y Academic_level.
     * 
     * Establece la relación a través de la tabla pivote `academic_level_academic_product`.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function academic_levels(){
        return $this->belongsToMany('App\Models\Academic_level','academic_level_academic_product');
    }
      /**
     * Relación muchos a muchos entre Academic_product y Acceptance_indicator.
     * 
     * Establece la relación a través de la tabla pivote `aproduct_aindicator`.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function acceptance_indicators(){
        return $this->belongsToMany('App\Models\Acceptance_indicator','aproduct_aindicator');
    }   
    
   
    /**
     * Relación muchos a muchos inversa entre Academic_product y Academic_process.
     * 
     * Establece la relación a través de la tabla pivote `academic_process_academic_product`.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function academic_processes(){
        return $this->belongsToMany('App\Models\Academic_process','academic_process_academic_product');
    }
}
