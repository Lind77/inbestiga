<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un Permiso de Asistencia.
 * 
 * Este modelo gestiona los permisos de asistencia que los usuarios pueden solicitar, 
 * incluyendo las fechas y razones por las cuales se ausentaron.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $status
 * @property int $attendance_id
 * @property \Illuminate\Support\Carbon|null $miss_date
 * @property string|null $miss_time_admission
 * @property string|null $miss_time_departure
 * @property string $reason
 * @property int $time_amount
 * @property int $left_time
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Attendance_permit extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['status', 'attendance_id', 'miss_date', 'miss_time_admission', 'miss_time_departure', 'reason', 'time_amount', 'left_time', 'user_id'];
     /**
     *Relación  uno a muchos inverso attendances-Attendance-permit
     * 
     * Un permiso de asistencia pertenece a un usuario.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    /**
     * Relación uno a muchos Attendance_permit-Recovery_dates
     * 
     * Permite asociar varias fechas de recuperación a un permiso de asistencia.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function recovery_dates()
    {
        return $this->morphMany('App\Models\Recovery_date', 'recoverable');
    }
}
