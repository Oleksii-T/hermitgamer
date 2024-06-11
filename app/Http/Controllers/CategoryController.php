<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category)
    {
        $perPage = 10;
        $posts = $category->posts()->publised()->latest()->paginate($perPage);
        $hasMore = $posts->hasMorePages();

        if (!$request->ajax()) {
            $page = Page::get('{category}');
            return view('categories.show', compact('category', 'posts', 'page', 'hasMore'));
        }

        return $this->jsonSuccess('', [
            'hasMore' => $hasMore,
            'html' => view('components.post-cards-with-pages', compact('posts'))->render()
        ]);
    }
}
