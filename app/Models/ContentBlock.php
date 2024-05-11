<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ContentBlock extends Model
{
    protected $fillable = [
        'name',
        'ident',
        'order',
    ];

    public function items()
    {
        return $this->hasMany(BlockItem::class, 'block_id');
    }

    public function blockable()
    {
        return $this->morphTo();
    }
}
