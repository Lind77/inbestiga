<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una Comisión.
 * 
 * Este modelo gestiona la información relacionada con las comisiones
 * generadas por las cotizaciones, incluyendo el concepto, el porcentaje
 * y el usuario asociado.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $quotation_id
 * @property string $concept
 * @property float $percent
 * @property string|null $referal
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Comission extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['quotation_id', 'concept', 'percent', 'referal', 'user_id'];
       /**
     * Relación inversa con User.
     * 
     * Una comisión pertenece a un usuario específico que la generó.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Relación inversa con Quotation.
     * 
     * Una comisión está asociada a una cotización específica.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }
}
