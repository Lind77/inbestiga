<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un descuento en el sistema.
 * 
 * Este modelo gestiona la información sobre descuentos aplicables
 * basados en el tiempo especificado.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $min_time
 * @property int $max_time
 * @property float $discount_percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Discount extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['min_time', 'max_time','discount_percent'];
    
    
}
