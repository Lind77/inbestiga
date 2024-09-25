<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una modalidad de grado en el sistema.
 * 
 * Este modelo gestiona la información sobre diferentes modalidades de 
 * grado y sus relaciones con otros modelos, como contratos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Degree_modality extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
    /**
     * Relación uno a muchos Degree-modality-contract.
     * 
     * Una modalidad de grado puede tener múltiples contratos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany('App\Models\Contract');
    }
    
}
