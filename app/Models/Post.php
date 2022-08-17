<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable;
use App\Traits\HasTranslations;
use App\Traits\HasAttachments;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model implements LocalizedUrlRoutable
{
    use HasFactory, HasTranslations, HasAttachments;

    protected $fillable = [
        'game_id',
        'category_id',
        'author_id',
        'is_active',
        'views',
    ];

    protected $appends = self::TRANSLATABLES + [

    ];

    const TRANSLATABLES = [
        'slug',
        'title',
        'content'
    ];

    const ATTACHMENTS = [
        'thumbnail',
        'images',
        'js',
        'css'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            foreach (self::ATTACHMENTS as $group) {
                $model->purgeFiles($group);
            }
            $model->purgeTranslations();
        });
    }

    public function thumbnail()
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('group', 'thumbnail');
    }

    public function images()
    {
        return $this->morphMany(Attachment::class, 'attachmentable')->where('group', 'images');
    }

    public function js()
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('group', 'js');
    }

    public function css()
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('group', 'css');
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function resolveRouteBinding($slug, $field = null)
    {
        return self::getBySlug($slug)?? abort(404);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCategory($query, $key, $get=false)
    {
        $res = $query->whereHas('category', function($q) use ($key){
            $q->where('key', $key);
        });

        return $get ? $res->get() : $res;
    }

    public function slug(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('slug')
        );
    }

    public function title(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('title')
        );
    }

    public function content(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('content')
        );
    }

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->addColumn('category', function ($model) {
                return $model->category->name;
            })
            ->addColumn('author', function ($model) {
                return $model->author->name;
            })
            ->editColumn('is_active', function ($model) {
                return $model->is_active
                    ? '<span class="badge badge-success">yes</span>'
                    : '<span class="badge badge-warning">no</span>';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(env('ADMIN_DATETIME_FORMAT'));
            })
            ->addColumn('action', function ($model) {
                return view('components.admin.actions', [
                    'model' => $model,
                    'name' => 'posts'
                ])->render();
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }
}
