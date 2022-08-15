<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Game extends Model
{
    use HasTranslations;

    protected $fillable = [
        'updated_at' // fix for mass assignment
    ];

    protected $appends = self::TRANSLATABLES + [

    ];

    const TRANSLATABLES = [
        'name',
        'slug',
        'description'
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

    public function name(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('name')
        );
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
