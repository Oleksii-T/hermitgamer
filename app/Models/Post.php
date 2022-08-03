<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\File;
use App\Traits\TranslationTrait;

class Post extends Model
{
    use TranslationTrait;

    protected $fillable = [
        'game_id',
        'category_id',
        'is_active',
        'css',
        'js',
    ];

    public static $translatable = [
        'title',
        'slug',
        'content'
    ];

    protected $casts = [
        'css' => File::class,
        'js' => File::class
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
