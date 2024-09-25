<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un distrito en el sistema.
 * 
 * Este modelo gestiona la información sobre los distritos,
 * incluyendo su relación con provincias y departamentos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $province_id
 * @property int $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class District extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','province_id','department_id'];
    /**
     * Relacion inversa uno amuchos Department-Province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
     /**
     * Relación inversa uno a muchos Department-District.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function department()
     {
         return $this->belongsTo('App\Models\Department');
     }
}
