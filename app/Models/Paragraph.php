<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    protected $fillable = [
        'title',
        'text',
        'group'
    ];

    public function paragraphable()
    {
        return $this->morphTo();
    }
}
