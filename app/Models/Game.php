<?php

namespace App\Models;

use App\Traits\GetAllSlugs;
use App\Traits\HasAttachments;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Game extends Model
{
    use HasAttachments, GetAllSlugs;

    const ATTACHMENTS = [
        'thumbnail',
        'esbr_image',
        'screenshots',
    ];

    private $thumbnail = null;
    private $esbr_image = null;

    protected $fillable = [
        'name', 
        'slug',
        'rating',
        'meta_title',
        'meta_description',
        'metacritic',
        'users_score',
        'release_date',
        'developer',
        'publisher',
        'platforms',
        'ganres',
        'esbr',
        'description',
        'summary',
        'hours',
        'updated_at' // fix for mass assignment
    ];

    protected $casts = [
        'release_date' => 'date',
        'hours' => 'array',
    ];

    // overload laravel`s method for route key generation
    public function getRouteKey()
    {
        return $this->slug;
    }

    public function thumbnail()
    {
        if (!$this->thumbnail) {
            $this->thumbnail = $this->morphToMany(Attachment::class, 'attachmentable')->where('group', 'thumbnail')->first();
        }

        return $this->thumbnail;
    }

    public function esbr_image()
    {
        if (!$this->esbr_image) {
            $this->esbr_image = $this->morphToMany(Attachment::class, 'attachmentable')->where('group', 'esbr_image')->first();
        }

        return $this->esbr_image;
    }

    public function screenshots()
    {
        return $this->morphToMany(Attachment::class, 'attachmentable')->where('group', 'screenshots');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->addColumn('name', function ($model) {
                return $model->name;
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(env('ADMIN_DATETIME_FORMAT'));
            })
            ->addColumn('action', function ($model) {
                return view('components.admin.actions', [
                    'model' => $model,
                    'name' => 'games'
                ])->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
