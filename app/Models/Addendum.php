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
    protected $fillable = ['addendumable_id','addendumable_type', 'date','object','clausele'];
    
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
}
