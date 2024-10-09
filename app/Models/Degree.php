<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un grado académico en el sistema.
 * 
 * Este modelo gestiona la información sobre diferentes grados académicos 
 * y sus relaciones con facultades y carreras.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Degree extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
    /**
     * Relación muchos a muchos university_degree.
     * 
     * Un grado puede pertenecer a múltiples facultades y viceversa.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function faculties()
    {
        return $this->belongsToMany("App\Models\Faculty", 'degree_faculty');
    }
    /**
     * Relación muchos a muchos career_degree.
     * 
     * Un grado puede estar asociado a múltiples carreras y viceversa.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function careers()
    {
        return $this->belongsToMany("App\Models\Career", 'career_degree');
    }
}
