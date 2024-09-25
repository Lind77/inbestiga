<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa los detalles de un comprobante de pago.
 *
 * Este modelo gestiona la información de cada detalle asociado a un comprobante de pago,
 * incluyendo el nombre del producto, precio, nivel y cantidad.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $payment_proof_id ID del comprobante de pago asociado.
 * @property string $product_name Nombre del producto.
 * @property float $price Precio del producto.
 * @property string|null $level Nivel del producto.
 * @property int $amount Cantidad del producto.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Proof_detail extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['payment_proof_id','product_name','price','level','amount'];
    /**
     * Relacion uno a muchos inversa payment_proofs-proof_details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment_proof(){
     return $this->belongsTo('App\Models\Payment_proof');
    }
}
