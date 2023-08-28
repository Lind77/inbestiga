<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_applicant extends Model
{
    use HasFactory;
    protected $fillable=['name','last_name','dni','cellphone','email','career','academic_degree','data_protection'];
    //Relación polimorfica uno a muchos (Job_Aplincant-Files)
    public function files(){
        return $this->morphMany('App\Models\File','fileable');
    }
    //Relación polimorfica uno a muchos (Job_Aplincant-Files)
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }
}
