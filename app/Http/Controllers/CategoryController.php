<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category, $page=1)
    {
        $perPage = 10;
        $page = abs((int) filter_var($page, FILTER_SANITIZE_NUMBER_INT));
        $posts = $category->posts()->publised()->latest()->paginate($perPage, ['*'], 'page', $page);
        $hasMore = $posts->hasMorePages();

        if (!$request->ajax()) {
            $page = Page::get('{category}');
            return view('categories.show', compact('category', 'posts', 'page', 'hasMore'));
        }

        return $this->jsonSuccess('', [
            'hasMore' => $hasMore,
            'html' => view('components.post-cards-with-pages', compact('posts', 'category'))->render()
        ]);
    }
}
