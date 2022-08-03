<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'users' => User::latest()->limit(5)->get(),
            'users_total' => User::count(),
            'pages' => Page::latest()->limit(5)->get(),
            'pages_total' => Page::count(),
            'plans' => [],
            'plans_total' => 0,
            'subscriptions' => [],
            'subscriptions_total' => 0,
        ];

        return view('admin.index', compact('data'));
    }
}
