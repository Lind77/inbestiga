<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Modelo que representa una entrega en el sistema.
 * 
 * Este modelo gestiona la información sobre entregas relacionadas con proyectos,
 * así como las relaciones con otros modelos como actividades asignadas y estados.
 * 
 * @category Model
 * @package  App\Models
 *
 * @property int $id
 * @property int $deliverable_id
 * @property string $deliverable_type
 * @property string $date
 * @property string|null $academic_date
 * @property float|null $advance
 * @property float|null $progress
 * @property string|null $type
 * @property string $status
 * @property int|null $project_id
 * @property string|null $complexity
 * @property int|null $user_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class Delivery extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = ['deliverable_id', 'deliverable_type', 'date', 'academic_date', 'advance', 'progress', 'type', 'status', 'project_id','complexity','user_id','description','addendum_id'];
    /**
     * Relacion inversa uno amuchos Project-Delivery.
     * 
     * Una entrega pertenece a un proyecto.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    /**
     * Relacion inversa uno amuchos Project-Delivery.
     * 
     * Una entrega pertenece a un proyecto.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addendum()
    {
        return $this->belongsTo('App\Models\Addendum');
    }
    /* //relacion muchos amuchos morfeable_qualityindicators_(project,delivery,assigned_task,assigned_activity)
    public function quality_indicators()
    {
        return $this->morphToMany('App\Models\Quality_indicator', 'quality_indicable');
    } */
     /**
     * Relacion morfeable uno a muchos (Project-delivery-assigned_activity-ntasks--quality_indicators).
     * 
     * Una entrega puede tener múltiples indicadores de calidad.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function quality_indicators(){
        return $this->morphMany('App\Models\Quality_indicator','quality_indicable');
    }
    /**
     * Relación uno a muchos polimorfico Delivery - Assigned_activity.
     * 
     * Una entrega puede tener múltiples actividades asignadas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function assigned_activities()
    {
        return $this->morphMany('App\Models\Assigned_activity', 'assigned_activitiable');
    }
     /**
     * relacion uno a muchos morfeable morfeable(project,delivery,assigned_task,assigned_activity).
     * 
     * Una entrega puede tener múltiples registros de progreso.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function progress()
    {
        return $this->morphMany('App\Models\Progress', 'progressable');
    }
     /**
     * Relacion morfeable uno a muchos project,deliveris,assigned_activities,assigned_task).
     * 
     * Una entrega puede tener múltiples observaciones.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function observations()
    {
        return $this->morphMany('App\Models\Observation', 'observable');
    }
    /**
     * Relación polimorfica uno a muchos (Status-Entities).
     * 
     * Una entrega puede tener múltiples estados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function statuses(){
        return $this->morphToMany('App\Models\Status','statusable');
    }   
    /**
     * Relación polimorfica de muchos a muchos (Status-Usuarios).
     * 
     * Una entrega puede estar asociada a múltiples usuarios.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
     public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    }
    /**
     * Relación polimórfica uno a muchos con Link.
     * 
     * Una entrega puede tener múltiples enlaces.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function links()
    {
        return $this->morphMany('App\Models\Links', 'linkable');
    }
    /**
     * Relación polimorfica uno a muchos (Entities-Images).
     * 
     * Una entrega puede tener múltiples imágenes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
    /**
     * Relación polimorfica uno a muchos (Entities-Icon).
     * 
     * Una entrega puede tener múltiples íconos.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function icons()
    {
        return $this->morphMany('App\Models\Icon', 'iconable');
    }
    /**
     * Relación polimorfica uno a mucho (Entities-File).
     * 
     * Una entrega puede tener múltiples archivos.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->mophMany('App\Models\File', 'fileable');
    }
    /**
     * Relación polimórfica para el modelo que puede ser entregado.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function deliverable()
    {
        return $this->morphTo();
    }
    /**
     * Relación uno a muchos inverso User-Delivery.
     * 
     * Una entrega pertenece a un usuario.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
