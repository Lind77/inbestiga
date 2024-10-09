<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa la Asistencia de un Usuario.
 * 
 * Este modelo gestiona los registros de asistencia de los usuarios, 
 * incluyendo información sobre los horarios de entrada y salida, 
 * así como los permisos de asistencia relacionados.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date
 * @property float|null $discount
 * @property string|null $first_punch
 * @property string|null $last_punch
 * @property string $weekday
 * @property string $status
 * @property int|null $worked_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Attendance extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'date', 'discount','first_punch', 'last_punch','weekday','status','worked_time'];
    /**
     * Relacion uno a muchos inversa User-Attendance
     * 
     * Una asistencia pertenece a un usuario.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    /**
     * Relacion uno a muchos attendances-attendances_permits.
     * 
     * Un registro de asistencia puede tener múltiples permisos de asistencia relacionados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendance_permits(){
        return $this->hasMany('App\Models\Attendance_permit');
    }
}
