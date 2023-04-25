<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comission extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'concept', 'percent', 'referal', 'user_id'];
}
