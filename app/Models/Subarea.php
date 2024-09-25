<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una subárea dentro de un área más grande.
 *
 * Este modelo se utiliza para gestionar las subáreas, que pueden estar relacionadas
 * con un área y pueden tener usuarios y roles asociados.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único de la subárea.
 * @property string $name Nombre de la subárea.
 * @property int $area_id Identificador del área a la que pertenece la subárea.
 * @property int|null $father_id Identificador de la subárea padre (si aplica).
 * @property int $heirarchy Nivel jerárquico de la subárea.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Subarea extends Model
{
  use HasFactory;
  /**
   * Los atributos que son asignables en masa.
   *
   * @var array<int, string>
   */
  protected $fillable = ['name', 'area_id','father_id','heirarchy'];
  /**
     * Relación  inversa uno a muchos Area-Subarea.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
  public function area()
  {
    return $this->belongsTo('App\Models\Area');
  }
   /**
     * Relación  uno a muchos Subarea-User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
  public function users()
  {
    return $this->hasMany('App\Models\User');
  }
  /**
  * Relación  polimorficaa uno a muchos dasdas asv.
  *
  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  */   
  public function roles()
  {
    return $this->hasMany('\Spatie\Permission\Models\Role');
  }
  /* //Relación uno a muchos polimorfica 
  public function roles()
  {
      return $this->morphMany('\Spatie\Permission\Models\Role', 'roleable');
  } */
}
