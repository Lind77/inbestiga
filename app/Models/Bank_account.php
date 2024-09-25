<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una Cuenta Bancaria.
 * 
 * Este modelo gestiona la información de las cuentas bancarias, 
 * incluyendo el número de cuenta, el titular y la entidad bancaria.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $account_number
 * @property string $account_holder
 * @property string $type
 * @property int $bank_entity_id
 * @property string|null $cci
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Bank_account extends Model
{
    use HasFactory;
       /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['account_number','account_holder','type','bank_entity_id','cci'];
    /**
     * Relación inversa uno a muchos bank_entity-bank_account.
     * 
     * Una cuenta bancaria pertenece a una entidad bancaria.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank_entity(){
        return $this->belongsTo('App\Models\Bank_entity');
    }
    /**
     *Relación uno a muchos Customer-External_voucher.
     * 
     * Una cuenta bancaria puede tener múltiples vouchers externos relacionados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function external_vouchers(){
        return $this->hasMany('App\Models\External_voucher');
    }
    /**
     * Relación muchos a muchos Bank_account-Payment_method.
     * 
     * Una cuenta bancaria puede estar asociada a múltiples métodos de pago 
     * y viceversa.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payment_methods(){
        return $this->belongsToMany("App\Models\Payment_method", 'bank_account_payment_method');
    }
}
