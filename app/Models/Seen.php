<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa la visualización de notificaciones por parte de los usuarios.
 *
 * Este modelo gestiona la información sobre qué notificaciones han sido vistas 
 * por cada usuario, permitiendo llevar un registro de las notificaciones leídas 
 * y no leídas.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único de la visualización.
 * @property int $user_id ID del usuario que ha visto la notificación.
 * @property int $notification_id ID de la notificación vista.
 * @property bool $seen Estado de la notificación (true si se ha visto, false en caso contrario).
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Seen extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'notification_id','seen'];
}
