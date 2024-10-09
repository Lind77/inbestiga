<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una sede de una compañía.
 * 
 * Este modelo gestiona la información relacionada con las sedes 
 * de una empresa, incluyendo su relación con la compañía y las áreas.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Headquarter extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name','address','company_id'];
    /**
     * Relación inversa uno a muchos  Company-Headquearters.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
    /**
     *Relación uno a muchos Headquarter-Areas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areas(){
        return $this->belongsToMany('App\Models\Area','area_headquarter');
    }
}
