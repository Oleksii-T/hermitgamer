<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'updated_at' // fix for mass assignment
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
                    'name' => 'tags'
                ])->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
