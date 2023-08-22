<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    //Relación polimorfica de muchos a muchos (Status-Usuarios)
    public function users()
    {
        return $this->morphToMany('App\Models\User', 'levelable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function notes(){
      return $this->morpehdByMany('App\Models\Note','statusable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function projects(){
        return $this->morpehdByMany('App\Models\Project','statusable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function deliveries(){
        return $this->morpehdByMany('App\Models\Delivery','statusable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function assigned_activities(){
        return $this->morpehdByMany('App\Models\Assigned_activity','statusable');
    }
    //Relación polimorfica uno a muchos (Usuario-(Status)(notes-))
    public function ntasks(){
        return $this->morpehdByMany('App\Models\Ntask','statusable');
    }


}
