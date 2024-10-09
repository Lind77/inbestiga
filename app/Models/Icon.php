<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un icono asociado a diferentes entidades.
 * 
 * Este modelo gestiona la información relacionada con los iconos 
 * que pueden estar asociados a múltiples entidades a través de 
 * una relación polimórfica.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $iconable_id
 * @property string $iconable_type
 * @property string $class
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Icon extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['iconable_id','iconable_type','class'];
    /**
     * Relacion polimorfica uno a muchos inversa Entities-Icons.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
     public function iconable(){
        return $this->morphTo();
    }    
}
