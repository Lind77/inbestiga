<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una Categoría.
 * 
 * Este modelo gestiona la información de las categorías, 
 * incluyendo su nombre y los niveles académicos e íconos asociados.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
     /**
     * Relacion uno a muchos Category-Projects.
     * 
     * Una categoría puede tener múltiples niveles académicos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function academic_levels(){
        return $this->hasMany('App\Models\Academic_level');
    }
    /**
     * Relación uno a muchos Category-Icon.
     * 
     * Una categoría puede tener múltiples íconos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function icons(){
        return $this->morphMany('App\Models\Icon','iconeable');
    }
}
