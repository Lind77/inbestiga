<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa un formulario en el sistema.
 * 
 * Este modelo gestiona la información relacionada con los formularios 
 * y su relación con la situación de un proyecto.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $forms
 * @property int $project_situation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Form extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name','forms','project_situation_id'];
     /**
     * Relación polimorfica inversa uno a muchos project_situation-form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project_situation(){
        return $this->belongsTo('App\Models\Project_situation');
    }
}
