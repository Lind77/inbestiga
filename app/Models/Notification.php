<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una notificación en el sistema.
 * 
 * Este modelo permite gestionar las notificaciones que pueden ser enviadas
 * a los usuarios, incluyendo su contenido, emisor y estado de visualización.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $emisor_id ID del usuario que envía la notificación.
 * @property string $content Contenido de la notificación.
 * @property string $type Tipo de notificación (e.g., alerta, mensaje).
 * @property mixed $extra Información adicional relacionada con la notificación.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Notification extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['notificable_id','notificable_type','content', 'type','extra'];
    /**
     * Relacion polimorfica uno a muchos inversa contract_orders-payments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notificable(){
        return $this->morphTo();
    } 
    /**
     * Relacion uno a muchos notificaciomseens.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function seens()
    {
        return $this->hasMany("App\Models\Seen");
    }
}
