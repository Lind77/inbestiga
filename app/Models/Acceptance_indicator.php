<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un Indicador de Aceptación.
 * 
 * Este modelo está relacionado con productos académicos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Acceptance_indicator extends Model
{
    use HasFactory;
      /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name'];
     /**
     * Relación muchos a muchos entre Acceptance_indicator y Academic_product.
     * 
     * Establece la relación a través de la tabla pivote `aproduct_aindicator`.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function academic_products(){    
        return $this->belongsToMany('App\Models\Academic_product','aproduct_aindicator');
    }
}
