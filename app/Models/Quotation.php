<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una cotización en el sistema.
 *
 * Este modelo gestiona la información relacionada con las cotizaciones,
 * incluyendo los clientes asociados, los detalles de la cotización,
 * y las órdenes o contratos generados a partir de ellas.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $customer_id ID del cliente asociado a la cotización.
 * @property \Illuminate\Support\Carbon $date Fecha de creación de la cotización.
 * @property float $amount Monto total de la cotización.
 * @property \Illuminate\Support\Carbon $expiration_date Fecha de expiración de la cotización.
 * @property float $discount Descuento aplicado a la cotización.
 * @property int $term Término de la cotización.
 * @property string|null $note Notas adicionales sobre la cotización.
 * @property string $status Estado de la cotización.
 * @property string|null $attitude Actitud relacionada con la cotización.
 * @property float|null $interest Interés asociado a la cotización.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Quotation extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['customer_id', 'date', 'amount', 'expiration_date', 'discount', 'term', 'note', 'status', 'attitude', 'interest'];
     /**
     * Relación inersa muchos a muhos customer-quotation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany("App\Models\Customer", 'customer_quotation');
    }
     /**
     * Relación uno a muchos Quotation-Details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany("App\Models\Detail");
    }
    /**
     *  Relación uno a uno Quotation-Order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne("App\Models\Order");
    }
    /**
     * Relación uno a uno Quotation-Contract.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contract()
    {
        return $this->hasOne("App\Models\Contract");
    }
    /**
     * Relación muchos a muchos user-customer-comissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comissions()
    {
        return $this->hasMany("App\Models\Comission");
    }
      /**
     * Relacion morfeable uno a muchos (O-C-PAYMENT).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments(){
        return $this->morphMany('App\Models\Payment', 'paymentable');
    }
}
