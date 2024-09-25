<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una Comunicación.
 * 
 * Este modelo gestiona la información relacionada con las interacciones
 * realizadas con los clientes, incluyendo detalles de gestión y comentarios.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $customer_id
 * @property string|null $first_management
 * @property string|null $last_management
 * @property string|null $next_management
 * @property string|null $comment
 * @property string|null $product_tentative
 * @property string|null $type
 * @property string|null $time
 * @property bool $attended
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Comunication extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['customer_id', 'first_management', 'last_management', 'next_management', 'comment', 'product_tentative', 'type','time','attended'];
    /**
     * Relacion inversa uno a muchos Customer-comunications.
     * 
     * Una comunicación pertenece a un cliente específico.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }
}
