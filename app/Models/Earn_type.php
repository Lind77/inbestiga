<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un tipo de ganancia en el sistema.
 * 
 * Este modelo gestiona los diferentes tipos de ganancias que
 * pueden estar asociados a los vales externos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Earn_type extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
    /**
     * Relacion uno a muchos Earn_type-External-voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function external_vouchers(){
    return $this->hasMany('App\Models\External_voucher');    
    }
}
