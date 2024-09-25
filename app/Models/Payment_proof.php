<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa la prueba de pago en el sistema.
 * 
 * Este modelo se encarga de almacenar información relacionada con los
 * comprobantes de pago, incluyendo detalles sobre el cliente y los 
 * productos o servicios adquiridos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $payment_proofable_id ID del recurso asociado (pago, producto, etc.).
 * @property string $payment_proofable_type Tipo del recurso asociado.
 * @property int $customer_id ID del cliente asociado con el comprobante.
 * @property string $code Código del comprobante.
 * @property \Illuminate\Support\Carbon $date Fecha del comprobante.
 * @property float $subtotal Monto subtotal del comprobante.
 * @property float $tax Importe del impuesto.
 * @property float $discount Descuento aplicado.
 * @property float $total_price Precio total del comprobante.
 * @property string $type Tipo de comprobante.
 * @property float $remaining_amount Monto restante por pagar.
 * @property string $pay_detail Detalles del pago.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Payment_proof extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['payment_proofable_id', 'payment_proofable_type', 'customer_id', 'code', 'date', 'subtotal', 'tax', 'discount', 'total_price', 'type', 'remaining_amount', 'pay_detail'];
     /**
     * Relacion uno a muchos payment_proofs-proof_details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proof_details()
    {
        return $this->hasMany('App\Models\Proof_detail');
    }
     /**
     * Relacion polimorfica uno a muchos unversa payments_(módulo de venta d eproductos o cursos online)-payment_proofs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function payment_proofable()
    {
        return $this->morphTo();
    }
    /**
     * Relación uno a muchos entre Payment_proof y Customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
