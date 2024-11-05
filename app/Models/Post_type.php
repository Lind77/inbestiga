<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_type extends Model
{
    use HasFactory;
    /**
     * Los atributos que son asignables en masa a post_typw.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    /**
     * Relacion uno a muchos Post_type - Posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function posts()
    {
        return $this->hasMany("App\Models\Post");
    }
    
}
