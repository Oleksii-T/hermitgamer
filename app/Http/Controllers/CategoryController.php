<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category)
    {
        $perPage = 2;
        $posts = $category->posts()->publised()->latest()->paginate($perPage);
        
        if (!$request->ajax()) {
            $page = Page::get('category');
            return view('categories.show', compact('category', 'posts', 'page'));
        }

        return $this->jsonSuccess('', [
            'hasMore' => $posts->hasMorePages(),
            'html' => view('components.post-cards', compact('posts'))->render()
        ]);
    }
}
