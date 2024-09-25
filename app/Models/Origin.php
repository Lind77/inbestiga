<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa el origen de un cliente en el sistema.
 * 
 * Este modelo permite gestionar información sobre cómo y a través de qué 
 * canal se adquirió un cliente, así como el usuario responsable de la 
 * gestión del cliente.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $customer_id ID del cliente asociado.
 * @property string $type Tipo de origen (e.g., referido, publicidad).
 * @property string $channel Canal a través del cual se adquirió el cliente.
 * @property int $user_id ID del usuario responsable.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Origin extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['customer_id', 'type', 'channel', 'user_id'];
    /**
     * Relacion inversa uno a uno customer-origin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }



}
