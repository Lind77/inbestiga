<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = ['progressable_id','progressable_type','comment','percentage','owner','start_time', 'end_time'];

    public function progressable()
    {
        return $this->morphTo();
    }
}
