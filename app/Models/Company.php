<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable=['name','phone','email','job_days','job_schedule_entry','job_schedule_departure'];
    //Relación uno muchos Company-Headquearters
    public function headquarters(){
        return 
        $this->hasMany('App\Models\Headquarter');
    }
    //Relacion morfeable Company-links
    public function links(){
        return $this->morphMany('App\Models\Link', 'linkable');
    }
}
