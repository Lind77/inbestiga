<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un contrato de trabajo en el sistema.
 *
 * Este modelo se utiliza para gestionar la información relacionada
 * con los contratos de trabajo, incluyendo cláusulas, salario, tipo
 * y estado del contrato, así como su asociación con un usuario.
 *
 * @category Model
 * @package  App\Models
 *
 * @property int $id Identificador único del contrato de trabajo.
 * @property string $clausule Cláusula del contrato.
 * @property float $salary Salario asociado al contrato.
 * @property string $type Tipo de contrato (por ejemplo, temporal, indefinido).
 * @property string $status Estado del contrato (por ejemplo, activo, inactivo).
 * @property int|null $user_id Identificador del usuario asociado al contrato.
 * @property \Illuminate\Support\Carbon|null $created_at Fecha de creación del registro.
 * @property \Illuminate\Support\Carbon|null $updated_at Fecha de la última actualización del registro.
 */
class Work_contract extends Model
{
    use HasFactory;
       /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = ['clausule', 'salary','type','status','user_id'];
    /**
     * Relación uno a uno inverso user-work_contract.
     *
     * Este método define la relación donde un contrato de trabajo
     * pertenece a un único usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
     /**
     * Relación uno a muchos work_contract-clausules.
     *
     * Este método define la relación donde un contrato de trabajo
     * puede tener múltiples cláusulas asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
   public function clausules(){
    return $this->hasMany('App\Models\Clausule');
   }
}





