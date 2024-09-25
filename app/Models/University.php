<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una universidad.
 *
 * Este modelo se utiliza para gestionar la información relacionada 
 * con universidades y su relación con facultades.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único de la universidad.
 * @property string $name Nombre de la universidad.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class University extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
    /**
     * Relación muchos a muchos university_faculties.
     *
     * Este método establece la relación entre universidades y facultades
     * a través de la tabla pivote 'faculty_university'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function faculties(){
        return $this->belongsToMany("App\Models\Faculty", 'faculty_university');
    }
}
