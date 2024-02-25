<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostInfo extends Model
{
    protected $fillable = [
        'post_id',
        'advantages',
        'disadvantages',
        'rating',
        'game_details',
    ];

    protected $casts = [
        'advantages' => 'array',
        'disadvantages' => 'array',
        'game_details' => 'array',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
