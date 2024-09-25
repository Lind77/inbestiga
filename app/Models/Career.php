<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa una Carrera.
 * 
 * Este modelo gestiona la información de las carreras, 
 * incluyendo su nombre y los títulos asociados.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Career extends Model
{
    use HasFactory;
      /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
     /**
     * Relacion muchos a muchos Degree_career.
     * 
     * Una carrera puede estar asociada a múltiples títulos, 
     * y un título puede pertenecer a múltiples carreras.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function degrees()
    {
        return $this->belongsToMany("App\Models\Degree", 'career_degree');
    }
}
