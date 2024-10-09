<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un registro de conversación de IA.
 * 
 * Este modelo almacena los mensajes recibidos y enviados, así como información
 * relacionada con WhatsApp, incluyendo el ID, el número de teléfono y las marcas de tiempo.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $datetime
 * @property string $received_message
 * @property string $sent_message
 * @property string $id_wa
 * @property int $timestamp_wa
 * @property string $phone_wa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Aichat extends Model
{
    use HasFactory;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['datetime','received_message','sent_message','id_wa','timestamp_wa','phone_wa'];
}
