<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work_contract extends Model
{
    use HasFactory;
    protected $fillable = ['clausule', 'salary'];

    //relacion uno a muchos user-comissions
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
