<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PostBlock extends Model
{
    protected $fillable = [
        'post_id',
        'name',
        'ident',
        'order',
    ];

    public function items()
    {
        return $this->hasMany(BlockItem::class, 'block_id');
    }
}
