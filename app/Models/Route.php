<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Permissionr;      
class Route extends Model
{
    use HasFactory;
    protected $fillable = ['sidebar_name','route_name','icon_route'];
    //Realcion uno  a uno inversa Permission-Route   
    public function permission(){
    return $this->belongsTo('\Spatie\Permission\Models\Permission');
    }
}
