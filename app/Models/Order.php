<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un pedido en el sistema.
 * 
 * Este modelo permite gestionar los pedidos asociados a cotizaciones, 
 * así como sus pagos, proyectos y otros elementos relacionados.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $quotation_id ID de la cotización asociada al pedido.
 * @property string $final_delivery Fecha de entrega final del pedido.
 * @property string $observations Observaciones adicionales sobre el pedido.
 * @property string $suggested Sugerencias relacionadas con el pedido.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Order extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['quotation_id', 'final_delivery', 'observations', 'suggested'];
     /**
     * Relacion inversa uno  a uno Order-Quotation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quotation(){
        return $this->belongsTo('App\Models\Quotation');
    }
    /**
     * Relacion morfeable uno a muchos (O-C-PAYMENT).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments(){
        return $this->morphMany('App\Models\Payment', 'paymentable');
    }
    /**
     * Relacion morfeable uno a muchos (O-C-PROJECTS).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
     public function projects(){
        return $this->morphMany('App\Models\Project', 'projectable');
    }
    /**
     * Relacion polimorfica uno a mucho addendum-order-contract.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addendums(){
        return $this->morphMany('App\Models\Addendum', 'addendumable');
    }
    /**
     * Relacion morfeable uno a muchos (orders-contract-payments-payment_proofs).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
   public function payment_proofs(){
    return $this->morphMany('App\Models\Payment_proof', 'payment_proofable');
   }
   /**
     * Relación polimorfica uno a mucho (Contrato-Orden->Properties()).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
   public function properties(){
    return $this->morphMany('App\Models\Property', 'propertiable');
}
}
