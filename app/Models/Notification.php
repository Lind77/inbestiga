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
    protected $fillable = ['emisor_id', 'content', 'type','extra'];
    /**
     * Realción muchos a muchos users-notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany('App\Models\User','seens')->withPivot('id','seen');
    }
     /**
     * Relación uno a uno user notificaation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emisor(){
        return $this->belongsTo('App\Models\User', 'emisor_id');
    }
}
