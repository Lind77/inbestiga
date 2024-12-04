<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un Contrato.
 * 
 * Este modelo gestiona la información relacionada con los contratos,
 * incluyendo detalles financieros y relaciones con otras entidades.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $quotation_id
 * @property float $amount
 * @property string|null $amount_text
 * @property string|null $cent_text
 * @property string $date
 * @property float $advance
 * @property float $percentage
 * @property string|null $third_article
 * @property string|null $third_article_place
 * @property string|null $status
 * @property string|null $fifth_article
 * @property string|null $third_article_ppts
 * @property string|null $fragment
 * @property int $user_id
 * @property string|null $bank_account_type
 * @property int|null $degree_modality_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Contract extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['quotation_id', 'amount', 'amount_text', 'cent_text', 'date', 'advance', 'percentage', 'third_article', 'third_article_place', 'status', 'fifth_article', 'third_article_ppts', 'fragment', 'user_id', 'bank_account_type', 'degree_modality_id'];
    /**
     * Relacion inversa uno  a uno Contract-Quotation.
     * 
     * Un contrato pertenece a una cotización específica.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }
    /**
     * Relacion morfeable uno a muchos (O-C-PAYMENT).
     * 
     * Un contrato puede tener múltiples pagos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments()
    {
        return $this->morphMany('App\Models\Payment', 'paymentable');
    }
    /**
     * Relacion polimorfica uno a mucho addendum-order-contract.
     * 
     * Un contrato puede tener múltiples adendos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addendums()
    {
        return $this->morphMany('App\Models\Addendum', 'addendumable');
    }
     /**
     * Relacion morfeable uno a muchos (orders-contracts-payments-payment_proofs).
     * 
     * Un contrato puede tener múltiples comprobantes de pago.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payment_proofs()
    {
        return $this->morphMany('App\Models\Payment_proof', 'payment_proofable');
    }
    /**
     * Relacion morfeable uno a muchos (O-C-Projects).
     * 
     * Un contrato puede estar asociado a múltiples proyectos.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function projects()
    {
        return $this->morphMany('App\Models\Project', 'projectable');
    }
     /**
     * Relación polimorfica uno a mucho (Contrato-Orden->Properties()).
     * 
     * Un contrato puede tener múltiples propiedades asociadas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function properties()
    {
        return $this->morphMany('App\Models\Property', 'propertiable');
    }
     /**
     * Relación uno a muchos Contract-External_voucher.
     * 
     * Un contrato puede tener múltiples vouchers externos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function external_vouchers()
    {
        return $this->hasMany('App\Models\External_voucher');
    }
    /**
     * Relación uno a uno user-contract inversa.
     * 
     * Un contrato pertenece a un usuario específico que lo creó.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
     /**
     * Relacion inversa uno a muchos Degree-modality-Contract.
     * 
     * Un contrato pertenece a una modalidad de grado específica.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function degree_modality()
    {
        return $this->belongsTo('App\Models\Degree_modality');
    }
       /**
     * Relacion inversa uno a muchos Degree-modality-Contract.
     * 
     * Un contrato pertenece a una modalidad de grado específica.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thesis_type()
    {
        return $this->belongsTo('App\Models\Thesis_type');
    }
       /**
     * Relacion inversa uno a muchos Degree-modality-Contract.
     * 
     * Un contrato pertenece a una modalidad de grado específica.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thesis_degree()
    {
        return $this->belongsTo('App\Models\Thesis_degree');
    }
    public function post_forms()
    {
        return $this->morphMany('App\Models\Post_form', 'post_formable');
    }
}
