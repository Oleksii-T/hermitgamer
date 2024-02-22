<?php

namespace App\Models;

use App\Casts\File;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Author extends Model
{
    protected $fillable = [
        'name',
        'avatar',
        'title',
        'facebook',
        'instagram',
        'youtube',
        'email',
        'slug',
        'description',
        'steam'
    ];

    protected $casts = [
        'avatar' => File::class
    ];

    public $disk = 'authors';

    public function posts()
    {
        return $this->hasMany(Post::class);
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
