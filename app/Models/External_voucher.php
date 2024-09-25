<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un vale externo en el sistema.
 * 
 * Este modelo gestiona la información relacionada con los vales
 * externos, incluyendo detalles de pagos, conceptos, y relaciones
 * con otros modelos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $operation_code
 * @property float $amount
 * @property string $payment_concept
 * @property \Illuminate\Support\Carbon $date
 * @property string $status
 * @property string|null $observation
 * @property int|null $contract_id
 * @property int|null $customer_id
 * @property int|null $bank_account_id
 * @property int|null $payment_method_id
 * @property float|null $external_discount
 * @property float|null $internal_discount
 * @property float|null $partial_amount
 * @property float|null $taxes
 * @property float|null $net_profit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class External_voucher extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['operation_code','amount','payment_concept','date','status','observation','contract_id','customer_id','bank_account_id','payment_method_id','external_discount','internal_discount','partial_amount','taxes','net_profit'];
    /**
     * Relación uno a muchos inverso Payment_method-External_voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment_method(){
        return $this->belongsTo('App\Models\Payment_method');
    }
    /**
     * Relación uno a muchos inversa Customer-External_voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    Public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }
    /**
     * Relación inversa uno a muchos Contract-External_voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract(){
        return $this->belongsTo('App\Models\Contract');
    }
    /**
     * Relación inversa uno a muchos Bank_account-Contract.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank_account(){
        return $this->belongsTo('App\Models\Bank_account');
    }
    /**
     * Relación inversa uno a muchos Bank_account-Contract.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cpe(){
        return $this->belongsTo('App\Models\Cpe');
    }
    /**
     * Relación inversa uno a muchos Bank_account-Contract.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function earn_type(){
        return $this->belongsTo('App\Models\Earn_type');
    }
     /**
     * Relación polimorfica uno a muchos (Entities-Images).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
    /**
     * Relacion morfeable uno a muchos (External_voucher-payments-payment_proofs).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payment_proofs(){
         return $this->morphMany('App\Models\Payment_proof', 'payment_proofable');
    }
    
}
