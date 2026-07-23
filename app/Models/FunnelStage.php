<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunnelStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'color_status',
        'is_system'
    ];
}
