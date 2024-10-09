<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una provincia en un sistema de gestión geográfica.
 *
 * Este modelo gestiona la información relacionada con las provincias y su
 * relación con departamentos, distritos y clientes.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name Nombre de la provincia.
 * @property int $department_id ID del departamento al que pertenece la provincia.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Province extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','department_id'];
    /**
     * Relacion inversa uno amuchos Department-Province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
    
     /**
     * // Relación uno a muchos province-district.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }
    /**
     * Relación uno a muchos province-customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers(){
        return $this->hasMany('App\Models\Customer');
    }
}
