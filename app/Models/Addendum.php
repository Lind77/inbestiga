<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un Anexo (Addendum).
 * 
 * Este modelo está relacionado con otros modelos mediante una relación polimórfica,
 * permitiendo que un anexo se asocie a diferentes tipos de modelos (como órdenes o contratos).
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $addendumable_id
 * @property string $addendumable_type
 * @property string $date
 * @property string $object
 * @property string $clausele
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Addendum extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['addendumable_id','addendumable_type', 'date','object','clausele','status','amount','user_id'];
    
    /**
     * Relación polimórfica inversa uno a muchos.
     * 
     * Permite que un addendum pertenezca a diferentes modelos, como contratos u órdenes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addendumable(){
        return $this->morphTo();
    }   
      /**
     * Relación uno a muchos Project_Delivery.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries()
    {
        return $this->hasMany("App\Models\Delivery");
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
}
