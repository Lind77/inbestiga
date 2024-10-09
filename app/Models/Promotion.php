<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una promoción.
 *
 * Este modelo gestiona la información de las promociones disponibles,
 * incluyendo el código de promoción, porcentaje de descuento y límites.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $code Código de la promoción.
 * @property float $percent Porcentaje de descuento de la promoción.
 * @property int $quantity Cantidad de usos permitidos de la promoción.
 * @property bool $able Indica si la promoción está activa.
 * @property bool $discounted Indica si la promoción ya ha sido utilizada.
 * @property int|null $limit Límite de la promoción.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Promotion extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['code', 'percent', 'quantity', 'able', 'discounted', 'limit'];
}
