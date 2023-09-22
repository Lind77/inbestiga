<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aichat extends Model
{
    use HasFactory;
    protected $fillable=['datetime','received_message','sent_message','id_wa','timestamp_wa','phone_wa'];
}
