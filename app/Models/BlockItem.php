<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockItem extends Model
{
    protected $fillable = [
        'block_id',
        'type',
        'order',
        'value',
    ];

    const TYPES = [
        'title',
        'text',
        'image',
        'video',
        'slider'
    ];
}
