<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una imagen asociada a diferentes entidades.
 * 
 * Este modelo gestiona la información relacionada con las imágenes 
 * que pueden estar asociadas a múltiples entidades a través de 
 * una relación polimórfica.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $imageable_id
 * @property string $imageable_type
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Image extends Model
{
    use HasFactory;
      /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['imageable_id','imageable_type','url'];
    /**
     * Relacion polimorfica uno a muchos inversa Entities-Images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
     public function imageable(){
        return $this->morphTo();
    }    
}
