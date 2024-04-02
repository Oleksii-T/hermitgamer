<?php

namespace App\Models;

use App\Traits\Viewable;
use App\Enums\PostStatus;
use App\Enums\PostTCStyle;
use App\Traits\GetAllSlugs;
use Illuminate\Support\Str;
use App\Traits\HasAttachments;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, HasAttachments, Viewable, SoftDeletes, GetAllSlugs;

    protected $fillable = [
        'parent_id',
        'game_id',
        'slug',
        'title',
        'meta_title',
        'meta_description',
        'category_id',
        'author_id',
        'status',
        'intro',
        'conclusion',
        'tc_style',
        'related',
        'block_groups',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'related' => 'array',
        'block_groups' => 'array',
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

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
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

    public function introCropped(): Attribute
    {
        return new Attribute(fn () => Str::limit(strip_tags($this->intro), 250));
    }

    public function getSameGamePosts()
    {
        $res = [];
        $posts = self::query()
            ->where('game_id', $this->game_id)
            ->where('id', '!=', $this->id)
            ->latest()
            ->get();

        foreach ($posts as $post) {
            $group = $post->links_group;

            if (!$group) {
                $res[$post->id] = [$post];
                continue;
            }

            // $group = Str::slug($group);

            if ($res[$group] ?? false) {
                $res[$group][] = $post;
                continue;
            }

            $res[$group] = [$post];
        }

        return $res;
    }

    public function getGroupedBlocks()
    {
        $blockGroups = $this->block_groups;
        $blocks = $this->blocks->sortBy('order');
        $skip = 0;
        $res = [];

        foreach ($blockGroups as $a) {
            $res[] = $blocks->skip($skip)->take($a);
            $skip += $a;
        }

        return $res;
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
                return view('admin.posts.actions', [
                    'post' => $model,
                ])->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
