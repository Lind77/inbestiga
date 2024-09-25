<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un enlace en el sistema.
 * 
 * Este modelo permite gestionar enlaces que pueden estar asociados
 * a diferentes entidades a través de relaciones polimórficas.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $linkable_type
 * @property int $linkable_id
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Link extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['linkable_id','linkable_type','url'];
    /**
     * Relación polimorfica uno a muchos inversa Entities-Links.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
     public function linkable(){
        return $this->morphTo();
    }     
}
