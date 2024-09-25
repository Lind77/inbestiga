<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una Cláusula.
 * 
 * Este modelo gestiona la información de las cláusulas asociadas
 * a los contratos de trabajo, incluyendo su título y descripción.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $work_contract_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Clausule extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title','description ','work_contract_id'];
    /**
     * Relación inversa  de uno a muchos work_contract_Clausule.
     * 
     * Una cláusula pertenece a un contrato de trabajo específico.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function work_contract(){
        return $this->belongsTo('App\Models\Work_contract');
    }
}
