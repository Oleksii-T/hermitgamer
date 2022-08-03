<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        //
    ];

    protected $translatable = [
        'name',
        'slug'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
