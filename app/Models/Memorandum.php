<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un memorándum en el sistema.
 * 
 * Este modelo permite gestionar la información de un memorándum,
 * incluyendo sus emisores, receptores, detalles y estado.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $emisor_id ID del usuario que emite el memorándum.
 * @property int $receptor_id ID del usuario que recibe el memorándum.
 * @property string $subject Asunto del memorándum.
 * @property string $content Contenido del memorándum.
 * @property string $status Estado del memorándum (e.g. activo, inactivo).
 * @property \Illuminate\Support\Carbon $date Fecha de emisión del memorándum.
 * @property \Illuminate\Support\Carbon $expiration_date Fecha de expiración del memorándum.
 * @property string $type Tipo de memorándum.
 * @property float $total_amount Monto total asociado al memorándum.
 * @property string $code Código del memorándum.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Memorandum extends Model
{
    use HasFactory;
    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'memorandums';
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['emisor_id', 'receptor_id', 'subject', 'content', 'status', 'date', 'expiration_date', 'type', 'total_amount', 'code'];
     /**
     * Relación uno a muchos inversa User(receptor)-Memorandum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emisor()
    {
        return $this->belongsTo('App\Models\User', 'emisor_id');
    }
    /**
     * Relación uno a muchos inversa User(emisor)-Memorandum.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receptor()
    {
        return $this->belongsTo('App\Models\User', 'receptor_id');
    }
    /**
     * Relacion uno a muchos Memorandum-Memorandum_details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function memorandum_details()
    {
        return $this->hasMany('App\Models\Memorandum_detail');
    }
}
