<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un archivo en el sistema.
 * 
 * Este modelo gestiona la información relacionada con los archivos 
 * y su relación polimórfica con otras entidades.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $fileable_id
 * @property string $fileable_type
 * @property string $url
 * @property string $type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class File extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['fileable_id','fileable_type','url','type','status'];
    /**
     * Relacion polimorfica uno a muchos inversa Entities-Files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable(){
        return $this->morphTo();
    }    
}
