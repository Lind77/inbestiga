<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comission extends Model
{
    use HasFactory;

    protected $fillable = ['quotation_id', 'concept', 'percent', 'referal', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }
}
