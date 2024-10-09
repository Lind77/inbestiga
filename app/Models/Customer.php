<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa a un cliente en el sistema.
 * 
 * Este modelo gestiona la información del cliente y sus relaciones
 * con otros modelos, como cotizaciones, comunicaciones, y más.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $cell
 * @property string $dni
 * @property string $address
 * @property string|null $university
 * @property string|null $career
 * @property string $status
 * @property string $email
 * @property int|null $user_id
 * @property string|null $origin
 * @property string|null $time
 * @property string|null $needs
 * @property string|null $interest
 * @property string|null $attitude
 * @property int|null $userregister_id
 * @property string|null $birth_date
 * @property string|null $type
 * @property int|null $province_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'password', 'cell', 'dni', 'address', 'university', 'career', 'status', 'email', 'user_id', 'origin', 'time', 'needs', 'interest', 'attitude', 'userregister_id', 'birth_date', 'type','province_id'];
    /**
     * Relacion muchos a muchos Customer-Quotations.
     * 
     * Un cliente puede tener múltiples cotizaciones.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quotations()
    {
        return $this->belongsToMany("App\Models\Quotation", 'customer_quotation');
    }
    /**
     * Relacion uno a muchos custoemr-comunications.
     * 
     * Un cliente puede tener múltiples comunicaciones.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comunications()
    {
        return $this->hasMany("App\Models\Comunication");
    }
    /**
     * Relacion uno a muchos custoemr-origins.
     * 
     * Un cliente tiene un origen asociado.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function origin()
    {
        return $this->hasOne("App\Models\Origin");
    }
    /**
     * Relacion uno a muchos user -customer.
     * 
     * Un cliente pertenece a un usuario.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
     /**
     * Relación  polimorfica muchos a muchos user-meetings.
     * 
     * Un cliente puede estar asociado con múltiples reuniones.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function meetings()
    {
        return $this->morphToMany('App\Models\Meeting', 'meetingable');
    }
     /**
     * Relación uno a muchos Customer-External_voucher.
     * 
     * Un cliente puede tener múltiples vouchers externos asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function external_vouchers()
    {
        return $this->hasMany('App\Models\External_voucher');
    }
    /**
     * Relación polimorfica uno a muchos (User-Customer-Post).
     * 
     * Un cliente puede tener múltiples publicaciones asociadas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function posts()
    {
        return $this->morphMany('App\Models\Post', 'postable');
    }
    /**
     * Relacion inversa uno a muchos province-customer.
     * 
     * Un cliente pertenece a una provincia.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
}
