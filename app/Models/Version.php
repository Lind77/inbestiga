<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una versión del sistema.
 *
 * Este modelo se utiliza para gestionar la información relacionada
 * con las versiones, incluyendo su código, título, descripción y fecha.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único de la versión.
 * @property string $code Código de la versión.
 * @property string $title Título de la versión.
 * @property string $description Descripción de la versión.
 * @property \Illuminate\Support\Carbon $date Fecha de lanzamiento de la versión.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Version extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['code','title','description','date'];
     /**
     * Relacion uno a muchos (Version-Changes).
     *
     * Este método define la relación donde una versión puede tener
     * múltiples cambios asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function changes(){
        return $this->hasMany('App\Models\Change');
    }
    /**
     * Relación polimorfica Change-Images.
     *
     * Este método define la relación donde una versión puede tener
     * múltiples imágenes asociadas a través de la relación polimórfica.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
     public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
}
