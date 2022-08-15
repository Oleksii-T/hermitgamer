<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Yajra\DataTables\DataTables;
use App\Casts\File;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Author extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'avatar',
        'facebook',
        'instagram',
        'youtube',
        'email',
        'steam'
    ];

    protected $appends = self::TRANSLATABLES + [

    ];

    protected $casts = [
        'avatar' => File::class
    ];

    public $disk = 'authors';

    const TRANSLATABLES = [
        'slug',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->purgeTranslations();
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function slug(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('slug')
        );
    }

    public function description(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('description')
        );
    }

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->editColumn('avatar', function ($model) {
                return '<img src="'.$model->avatar.'" alt="">';
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
