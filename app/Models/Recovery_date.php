<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa una fecha de recuperación en el sistema.
 *
 * Este modelo gestiona la información relacionada con las fechas de recuperación
 * de asistencia, incluyendo el tiempo de admisión y salida, el monto recuperado,
 * y la relación con los permisos de asistencia.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $recovery_date Fecha de recuperación.
 * @property \Illuminate\Support\Carbon|null $admission_time Hora de admisión.
 * @property \Illuminate\Support\Carbon|null $departure_time Hora de salida.
 * @property float $amount_recovered Monto recuperado.
 * @property int $attendance_permit_id ID del permiso de asistencia asociado.
 * @property string $status Estado de la recuperación.
 * @property int $recoverable_id ID del modelo recuperable.
 * @property string $recoverable_type Tipo del modelo recuperable.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Recovery_date extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['recovery_date','admission_time', 'departure_time','amount_recovered','attendance_permit_id','status','recoverable_id','recoverable_type'];
    /**
     * Relación  inversa uno a muchos User-Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendance_permit(){
        return $this->belongsTo('App\Models\Attendance_permit');
    }
     /**
     * Relación polimorfica uno a muchos Justification-Attendance_permit-Recoverydate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function recoverable(){
        return $this->morphTo();
    }
}
