<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category)
    {
        $perPage = 6;
        $posts = $category->posts()->active()->latest()->limit(6)->get();

        return view('categories.show', compact('category', 'posts'));
    }
}
