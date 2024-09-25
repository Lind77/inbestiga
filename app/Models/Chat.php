<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un Chat.
 * 
 * Este modelo gestiona la información de los mensajes enviados
 * entre usuarios, incluyendo el emisor, el receptor y el estado de visualización.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $emisor_id
 * @property int $receptor_id
 * @property string $message
 * @property bool $viewed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Chat extends Model
{
    use HasFactory;
/**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['emisor_id', 'receptor_id', 'message', 'viewed'];
     /**
     * Relación inversa con User (Receptor).
     * 
     * Un chat es enviado a un receptor específico.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receptor()
    {
        return $this->belongsTo('App\Models\User', 'receptor_id');
    }

    /**
     * Relación inversa con User (Emisor).
     * 
     * Un chat es enviado por un emisor específico.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emisor()
    {
        return $this->belongsTo('App\Models\User', 'emisor_id');
    }
}
