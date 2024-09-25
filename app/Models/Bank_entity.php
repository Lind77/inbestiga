<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una Entidad Bancaria.
 * 
 * Este modelo gestiona la información de las entidades bancarias, 
 * incluyendo el nombre de la entidad y sus cuentas bancarias asociadas.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Bank_entity extends Model
{
    use HasFactory;
        /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
     /**
     *Relacion uno a muchos Bank_entity-Bank_accounts.
     * 
     * Una entidad bancaria puede tener múltiples cuentas bancarias asociadas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bank_accounts(){
        return $this->hasMany('App\Models\Bank_account');
    }
}
