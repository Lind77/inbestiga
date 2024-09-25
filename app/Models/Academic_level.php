<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un Nivel Académico.
 * 
 * Este modelo está relacionado con categorías, productos académicos y proyectos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class Academic_level extends Model
{
    use HasFactory;
       /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name','category_id'];
     /**
     * Relación muchos a muchos entre Academic_level y Academic_product.
     * 
     * Esta función establece la relación entre niveles académicos y productos académicos
     * a través de la tabla pivote `academic_level_academic_product`.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function academic_products(){
        return $this->belongsToMany('App\Models\Academic_product','academic_level_academic_product');
    }
     /**
     * Relación inversa uno a muchos con Category.
     * 
     * Cada nivel académico pertenece a una categoría.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
     /**
     * Relación uno a muchos entre Academic_level y Project.
     * 
     * Un nivel académico puede tener muchos proyectos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(){
        return $this->hasMany('App\Models\Project');
    }
}
