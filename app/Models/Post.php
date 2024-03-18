<?php

namespace App\Models;

use App\Traits\Viewable;
use App\Enums\PostStatus;
use App\Enums\PostTCStyle;
use App\Traits\HasAttachments;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, HasAttachments, Viewable;

    protected $fillable = [
        'game_id',
        'slug',
        'title',
        'category_id',
        'author_id',
        'status',
        'intro',
        'conclusion',
        'tc_style',
        'related',
    ];

    protected $casts = [
        'related' => 'array',
        'status' => PostStatus::class,
        'tc_style' => PostTCStyle::class
    ];

    const ATTACHMENTS = [
        'thumbnail',
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
        });
    }

    // overload laravel`s method for route key generation
    public function getRouteKey()
    {
        return $this->slug;
    }

    public function thumbnail()
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('group', 'thumbnail');
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

    public function info()
    {
        return $this->hasOne(PostInfo::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
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
        return $this->hasMany(PostBlock::class);
    }

    public function scopePublised($query)
    {
        return $query
            // ->has('blocks')
            ->where('status', PostStatus::PUBLISHED);
    }

    public function scopeCategory($query, $slug, $get=false)
    {
        $res = $query->whereRelation('category', 'slug', $slug);

        return $get ? $res->get() : $res;
    }

    public function getRelatedPosts()
    {
        return self::whereIn('id', $this->related??[])->latest()->get();
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
            ->addColumn('views', function ($model) {
                return $model->views()->count();
            })
            ->editColumn('status', function ($model) {
                return $model->status->readable();
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
            ->rawColumns(['action'])
            ->make(true);
    }
}
