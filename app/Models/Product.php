<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un producto en el sistema.
 * 
 * Este modelo gestiona la información relacionada con los productos,
 * incluyendo sus detalles, actividades y niveles.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name Nombre del producto.
 * @property string|null $description Descripción del producto.
 * @property string $type Tipo de producto.
 * @property string $mode Modo de operación del producto.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Product extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'description', 'type', 'mode'];
    /**
     * Realcion uno a mucho Product-Activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }
    /**
     * Relacion polimorficaa muchos a muchos (P-A-T-LEVELS).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function levels()
    {
        return $this->morphToMany('App\Models\Level', 'levelable')->withPivot('price');
    } 
    /**
     * Relación uno  a uno product-detail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail()
    {
        return $this->hasOne('App\Models\Detail');
    }
}
