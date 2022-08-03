<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'text'
    ];

    public function parent()
    {
        $this->belongsTo(Comment::class);
    }

    public function childs()
    {
        $this->hasMany(Comment::class);
    }
}
