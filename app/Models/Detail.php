<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un detalle de una cotización en el sistema.
 * 
 * Este modelo gestiona la información sobre los detalles específicos de una
 * cotización, incluyendo el producto relacionado y su precio.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $quotation_id
 * @property string $name
 * @property int $product_id
 * @property string|null $description
 * @property string $type
 * @property float $price
 * @property float $extra_price
 * @property string $level
 * @property string $mode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Detail extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['quotation_id','name', 'product_id', 'description', 'type', 'price', 'extra_price', 'level', 'mode'];
    /**
     * Relacion inversa uno a muchos Quotation detail.
     * 
     * Un detalle pertenece a una cotización.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }
     /**
     * Relacion inversa uno a uno Product-Detail.
     * 
     * Un detalle pertenece a un producto.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo("App\Models\Product");
    }
}
