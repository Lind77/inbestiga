<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un horario en el sistema.
 *
 * Este modelo gestiona la información relacionada con los horarios de los usuarios,
 * incluyendo la hora de admisión, la hora de salida, el tipo de horario, el día 
 * y la semana correspondiente.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único del horario.
 * @property string $admission_time Hora de admisión.
 * @property string $departure_time Hora de salida.
 * @property string $type Tipo de horario (por ejemplo, fijo, flexible).
 * @property string $day Día de la semana al que corresponde el horario.
 * @property int $week Número de la semana al que corresponde el horario.
 * @property int $user_id ID del usuario asociado al horario.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Schedule extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['admission_time', 'departure_time', 'type', 'day', 'week','user_id']; 
     /**
     * Relación inversa uno a muchos User-Schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
