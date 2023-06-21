<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addendum extends Model
{
    use HasFactory;
    protected $fillable = ['addendumable_id','addendumable_type', 'amount', 'date','content'];
    
    //Relacion morfeable uno a muchos addendums order contract
    public function addendumable(){
        return $this->morphTo();
    }   
}
