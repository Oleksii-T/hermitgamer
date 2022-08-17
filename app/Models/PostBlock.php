<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostBlock extends Model
{
    protected $fillable = [
        'post_id',
        'id',
        'order',
    ];

    public function items()
    {
        return $this->hasMany(BlockItem::class);
    }
}
