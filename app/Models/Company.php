<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una Empresa.
 * 
 * Este modelo gestiona la información relacionada con las empresas,
 * incluyendo su nombre, teléfono, email y horarios laborales.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $job_days
 * @property string|null $job_schedule_entry
 * @property string|null $job_schedule_departure
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Company extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name','phone','email','job_days','job_schedule_entry','job_schedule_departure'];
    /**
     * Relación uno muchos Company-Headquearters.
     * 
     * Una empresa puede tener múltiples sedes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function headquarters(){
        return 
        $this->hasMany('App\Models\Headquarter');
    }
    /**
     * Relacion morfeable Company-links.
     * 
     * Una empresa puede tener múltiples enlaces asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function links(){
        return $this->morphMany('App\Models\Link', 'linkable');
    }
}
