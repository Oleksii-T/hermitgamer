<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PageController extends Controller
{
    public function index()
    {
        $newsCount = 6;
        $posts = Post::active()->with('tags', 'category', 'game')->latest()->get();
        $latestNews = [
            $posts->where('category.key', 'news')->take($newsCount),
            $posts->where('category.key', 'news')->skip($newsCount)->take($newsCount),
            $posts->where('category.key', 'news')->skip($newsCount*2)->take($newsCount),
        ];
        $latestReviews = $posts->where('category.key', 'reviews')->take(6);
        $latestGuides = $posts->where('category.key', 'guides')->take(6);

        return view('index', compact('posts', 'latestNews', 'latestReviews', 'latestGuides'));
    }
}
