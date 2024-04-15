<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank_entity extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Relacion uno a muchos Bank_entity-Bank_accounts
    public function bank_accounts(){
        return $this->hasMany('App\Models\Bank_account');
    }
}
