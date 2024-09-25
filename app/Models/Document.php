<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un documento en el sistema.
 * 
 * Este modelo gestiona la información sobre los documentos
 * asociados a los usuarios, incluyendo su título, descripción y tipo.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $type
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Document extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['title','description','type','user_id'];
     /**
     * Relación inversa de uno a muchos user-document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
     return $this->belongsTo('App\Models\User');
    }
}
