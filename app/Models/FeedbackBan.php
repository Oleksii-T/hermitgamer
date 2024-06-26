<?php

namespace App\Models;

use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedbackBan extends Model
{
    const TYPES = [
        'user',
        'ip',
        'name',
        'email'
    ];

    const ACTIONS = [
        'abort',
        'spam'
    ];

    protected $guarded = [];

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->addColumn('tries', function ($model) {
                return $model->activities()->where('event', 'catch')->count();
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->adminFormat();
            })
            ->editColumn('is_active', function ($model) {
                return $model->is_active ? 'Active' : 'Inactive';
            })
            ->addColumn('actions', function ($model) {
                return view('admin.feedback-bans.actions', compact('model'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
