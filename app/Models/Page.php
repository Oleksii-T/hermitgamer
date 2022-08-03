<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Page extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'title',
        'link',
        'template',
        'content',
        'meta_title',
        'meta_description',
    ];

    CONST STATUSES = [
        'draft',
        'published',
        'static'
    ];

    CONST EDITABLE_STATUSES = [
        'draft',
        'published'
    ];

    public static function get($url)
    {
        return self::where('link', $url)->where('status', 'static')->first();
    }

    public function blocks()
    {
        return $this->hasMany(PageBlock::class);
    }

    public function isStatic()
    {
        return $this->status == 'static';
    }

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->editColumn('link', function ($model) {
                return '<a href="'.url($model->link).'" target="_blank">'.$model->link.'</a>';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(env('ADMIN_DATETIME_FORMAT'));
            })
            ->addColumn('action', function ($model) {
                return view('admin.pages.actions-list', compact('model'))->render();
            })
            ->rawColumns(['link', 'action'])
            ->make(true);
    }

    public function show($key, $default='')
    {
        $explode = explode(':', $key);
        $blockName = $explode[0];
        $dataName = $explode[1];
        return $this->blocks
            ->where('name', $blockName)
            ->first()
            ->show($dataName, $default);
    }
}
