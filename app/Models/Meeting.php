<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una reunión en el sistema.
 * 
 * Este modelo permite gestionar detalles sobre reuniones,
 * incluyendo participantes y su información asociada.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $title Título de la reunión.
 * @property \Illuminate\Support\Carbon $date Fecha de la reunión.
 * @property string $link Enlace para unirse a la reunión.
 * @property string $comment Comentarios adicionales sobre la reunión.
 * @property string $status Estado de la reunión.
 * @property string $time Hora de la reunión.
 * @property string $type Tipo de reunión.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Meeting extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'date', 'link', 'comment','status','date','time','type'];
    /**
     * Relacion polimorfica muchos a muchos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function users(){
    return $this->morphedByMany('App\Models\User','meetingable');
    }
    /**
     * Relacion polimorfica muchos a muchos .
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
     */
    public function customers(){
        return $this->morphedByMany('App\Models\Customer','meetingable');
    }
}
