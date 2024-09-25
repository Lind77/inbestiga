<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un departamento en el sistema.
 * 
 * Este modelo gestiona la información sobre departamentos y sus relaciones con
 * provincias y distritos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Department extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
     /**
     * Relacion inversa uno amuchos Department-Province.
     * 
     * Un departamento puede tener múltiples provincias.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provinces()
    {
        return $this->hasMany('App\Models\Province');
    }
     /**
     *  Relación uno a muchos Departmet-district.
     * 
     * Un departamento puede tener múltiples distritos.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }
}
