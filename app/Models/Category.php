<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    protected $fillable = [
        'in_menu',
        'name',
        'order',
        'slug'
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
