<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cell', 'university', 'career', 'grade'];

    public function quotation(){
        return $this->hasOne("App\Models\Customer");
    }

    public function project(){
        return $this->hasOne("App\Models\Project");
    }
}
