<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProcessProject extends Pivot
{
    protected $guarded = [];


    public function progresses()
    {
        return $this->morphMany("App\Models\Progress", 'progressable');
    }
}
