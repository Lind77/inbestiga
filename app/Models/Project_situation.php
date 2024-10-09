<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa la situación de un proyecto.
 *
 * Este modelo gestiona las diversas situaciones que puede tener un proyecto
 * y su relación con formularios y propiedades.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name Nombre de la situación del proyecto.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Project_situation extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
     /**
     * Relación uno a muchos entre Project_situation y Form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     public function forms(){
        return $this->hasMany("App\Models\Form");
    }
    /**
     * Relación uno a muchos entre Project_situation y Property.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties(){
        return $this->hasMany("App\Models\Property");
    }
}
