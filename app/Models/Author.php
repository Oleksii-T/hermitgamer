<?php

namespace App\Models;

use App\Traits\Viewable;
use App\Traits\GetAllSlugs;
use App\Traits\HasAttachments;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Author extends Model
{
    use HasAttachments, Viewable, GetAllSlugs;

    const ATTACHMENTS = [
        'avatar',
        'meta_thumbnail'
    ];

    protected $fillable = [
        'name',
        'title',
        'facebook',
        'instagram',
        'youtube',
        'email',
        'twitter',
        'slug',
        'description',
        'description_small',
        'meta_description',
        'meta_title',
        'steam'
    ];

    public $disk = 'authors';

    // overload laravel`s method for route key generation
    public function getRouteKey()
    {
        return $this->slug;
    }

    public function avatar()
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('group', 'avatar');
    }

    public function meta_thumbnail()
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('group', 'meta_thumbnail');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function paragraphs()
    {
        return $this->morphMany(Paragraph::class, 'paragraphable');
    }

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->editColumn('avatar', function ($model) {
                return '<img src="'.$model->avatar->url.'" alt="">';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(env('ADMIN_DATETIME_FORMAT'));
            })
            ->addColumn('action', function ($model) {
                return view('components.admin.actions', [
                    'model' => $model,
                    'name' => 'authors'
                ])->render();
            })
            ->rawColumns(['avatar', 'action'])
            ->make(true);
    }
}
