<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_form extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'comunication_channel_id', 'study_place_id', 'marketing_surce_id','hire_factor_id','contract_mode_id','academic_situation_id','professional_status_id','participation_id'];
    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }
    public function comunication_channel()
    {
        return $this->belongsTo('App\Models\Comunication_channel');
    }
    public function study_place()
    {
        return $this->belongsTo('App\Models\Study_place');
    }
    public function marketing_source()
    {
        return $this->belongsTo('App\Models\Marketing_source');
    }
    public function hire_factor()
    {
        return $this->belongsTo('App\Models\Hire_factor');
    }
    public function contract_mode()
    {
        return $this->belongsTo('App\Models\Contract_mode');
    }
    public function academic_situation()
    {
        return $this->belongsTo('App\Models\Academic_situation');
    }
    public function professional_status()
    {
        return $this->belongsTo('App\Models\Professional_status');
    }
    public function participation()
    {
        return $this->belongsTo('App\Models\Participation');
    }

}
