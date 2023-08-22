<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    //Relación polimorfica de muchos a muchos (Status-Usuarios)
    public function users(){
        return $this->morphToMany('App\Models\User', 'userable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function notes(){
      return $this->morphedByMany('App\Models\Note','statusable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function projects(){
        return $this->morphedByMany('App\Models\Project','statusable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function deliveries(){
        return $this->morphedByMany('App\Models\Delivery','statusable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function assigned_activities(){
        return $this->morphedByMany('App\Models\Assigned_activity','statusable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function ntasks(){
        return $this->morphedByMany('App\Models\Ntask','statusable');
    }
}
