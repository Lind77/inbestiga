<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa un solicitante de empleo en el sistema.
 * 
 * Este modelo gestiona la información relacionada con los solicitantes,
 * permitiendo almacenar detalles personales y documentos asociados.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $dni
 * @property string $cellphone
 * @property string $email
 * @property string $career
 * @property string $academic_degree
 * @property bool $data_protection
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Job_applicant extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable=['name','last_name','dni','cellphone','email','career','academic_degree','data_protection'];
    /**
     * Relación polimorfica uno a muchos (Job_Aplincant-Files).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files(){
        return $this->morphMany('App\Models\File','fileable');
    }
    /**
     * Relación polimorfica uno a muchos (Job_Aplincant-Files).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
}
