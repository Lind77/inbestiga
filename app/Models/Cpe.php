<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un CPE (Comprobante de Pago Electrónico).
 * 
 * Este modelo gestiona la información relacionada con los comprobantes
 * de pago electrónicos y sus relaciones con los vouchers externos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Cpe extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
    /**
     * Relacion uno a muchos Cpe-External-voucher.
     * 
     * Un CPE puede tener múltiples vouchers externos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function external_vouchers(){
    return $this->hasMany('App\Models\External_voucher');    
    }
}
