<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un pago en el sistema.
 * 
 * Este modelo se encarga de almacenar información relacionada con los
 * pagos realizados, incluyendo detalles sobre el monto, fecha y estado
 * del pago.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $paymentable_id ID del recurso asociado (contrato, orden, etc.).
 * @property string $paymentable_type Tipo del recurso asociado.
 * @property \Illuminate\Support\Carbon $date Fecha del pago.
 * @property float $amount Monto del pago.
 * @property float $advance Monto del anticipo.
 * @property float $percentage Porcentaje del pago.
 * @property string $status Estado del pago (pendiente, completado, etc.).
 * @property float $amount_remain Monto restante por pagar.
 * @property float $amount_payed Monto ya pagado.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class Payment extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['paymentable_id', 'paymentable_type','date','amount', 'advance', 'percentage','status','amount_remain','amount_payed'];
    /**
     * Relacion polimorfica uno a muchos inversa contract_orders-payments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function paymentable(){
        return $this->morphTo();
    }  
    /**
     * Relacion morfeable uno a muchos (payments-payment_proofs).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payment_proofs(){
        return $this->morphMany('App\Models\Payment_proof', 'payment_proofable');
    }
}
