<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PostBlock extends Model
{
    use HasTranslations;

    protected $fillable = [
        'post_id',
        'ident',
        'order',
    ];

    protected $hidden = [
        'translations',
    ];

    protected $appends = self::TRANSLATABLES + [

    ];

    const TRANSLATABLES = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->purgeTranslations();
        });
    }

    public function items()
    {
        return $this->hasMany(BlockItem::class, 'block_id');
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('name')
        );
    }
}
