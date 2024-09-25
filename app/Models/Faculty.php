<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una facultad en el sistema.
 * 
 * Este modelo gestiona la información relacionada con las facultades
 * y sus relaciones con universidades y grados académicos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property int|null $team_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Faculty extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','team_id'];
    /**
     * Relacion muchos a muchos University-Faculty.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function universities(){
        return $this->belongsToMany("App\Models\University", 'faculty_university');
    }
     /**
     * Relacion muchos a muchos faculty-degree.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */ 
     public function degrees()
     {
         return $this->belongsToMany("App\Models\Degree", 'degree_faculty');
     }
     /**
     * Relacion uno a muchos inversa team-career.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(){
        return $this->belongsTo("App\Models\Team");
    }
}
