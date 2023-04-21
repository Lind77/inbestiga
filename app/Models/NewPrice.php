<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewPrice extends Model
{
    use HasFactory;

    protected $fillable=['new_product_id', 'level', 'price'];
}
