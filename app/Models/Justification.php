<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una justificación en el sistema.
 * 
 * Este modelo gestiona la información relacionada con las justificaciones
 * presentadas por los usuarios, incluyendo detalles sobre ausencias y
 * motivos asociados.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $miss_date
 * @property string $miss_time_admission
 * @property string $miss_time_departure
 * @property string $reason
 * @property string $status
 * @property int $user_id
 * @property float $time_amount
 * @property float $left_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Justification extends Model
{
    use HasFactory;
        /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['miss_date', 'miss_time_admission', 'miss_time_departure', 'reason','status','user_id','time_amount','left_time'];
    /**
     * Relación  uno a muchos inverso attendances-Attendance-permit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }/**
     * Relacion morfeable uno a muchos (Justification-Attendance_permits-Recovery_dates).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
     public function recovery_dates()
     {
         return $this->morphMany('App\Models\Recovery_date','recoverable');
     }
     /**
     * Relación polimorfica uno a mucho (Entities-File).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files(){
        return $this->mophMany('App\Models\File','fileable');        
    }
}
