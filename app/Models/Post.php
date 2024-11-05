<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una publicación en el sistema.
 * 
 * Este modelo se encarga de almacenar información sobre las publicaciones
 * realizadas por los usuarios o clientes en relación con proyectos.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $postable_id ID del recurso asociado (usuario, cliente, etc.).
 * @property string $postable_type Tipo del recurso asociado.
 * @property string $title Título de la publicación.
 * @property string $body Contenido de la publicación.
 * @property int $project_id ID del proyecto asociado.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Post extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['postable_id', 'postable_type','title','body', 'project_id','post_type_id'];
    /**
     * Relación polimorfica inversa uno a muchos CUSTOMER-USER-POST.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function postable(){
        return $this->morphTo();
    }
    /**
     * Relación polimorfica inversa uno a muchos .
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(){
        return $this->belongsTo('App\Models\Project');
    }
    /**
     * Relación uno a muchos polimorfica Post-files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files(){
        return $this->morphMany('App\Models\File', 'fileable');
    }

      /**
     * Relacion inversa uno a muchos Post_type - Posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function post_type()
    {
        return $this->belongsTo("App\Models\Post_type");
    }
}
