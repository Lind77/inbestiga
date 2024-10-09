<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un método de pago en el sistema.
 * 
 * Este modelo permite gestionar la información relacionada con los métodos de
 * pago disponibles, así como su relación con los vouchers y las cuentas bancarias.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name Nombre del método de pago.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Payment_method extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
    /**
     * Relación uno a muchos Payment_method-voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function external_vouchers(){
        return $this->hasMany('App\Models\External_voucher');    
    }
     /**
     * relación muchos a muchos Bank_account-Payment_method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bank_accounts(){
        return $this->belongsToMany("App\Models\Bank_account", 'bank_account_payment_method');
    }
}
