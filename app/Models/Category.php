<?php

namespace App\Models;

use App\Traits\GetAllSlugs;
use App\Traits\HasAttachments;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    use HasAttachments, GetAllSlugs;

    const ATTACHMENTS = [
        'meta_thumbnail'
    ];

    protected $fillable = [
        'in_menu',
        'name',
        'description',
        'order',
        'slug',
        'meta_description',
        'meta_title',
    ];

    // overload laravel`s method for route key generation
    public function getRouteKey()
    {
        return $this->slug;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function meta_thumbnail()
    {
        return $this->morphToMany(Attachment::class, 'attachmentable')->where('group', 'meta_thumbnail')->first();
    }

    public function paginationLink($page)
    {
        $page = "page-$page";

        return route('categories.show', [
            'category' => $this,
            'page' => $page
        ]);
    }

    public static function forHeader()
    {
        return self::where('in_menu', true)->orderBy('order')->get();
    }

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->addColumn('name', function ($model) {
                return $model->name;
            })
            ->addColumn('in_menu', function ($model) {
                return $model->in_menu
                    ? '<span class="badge badge-success">yes</span>'
                    : '<span class="badge badge-warning">no</span>';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(env('ADMIN_DATETIME_FORMAT'));
            })
            ->addColumn('action', function ($model) {
                return view('components.admin.actions', [
                    'model' => $model,
                    'name' => 'categories'
                ])->render();
            })
            ->rawColumns(['in_menu', 'action'])
            ->make(true);
    }
}
