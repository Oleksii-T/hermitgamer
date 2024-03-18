<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Author;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $page = Page::get('/');
        $q = Post::publised()->latest();
        $latestReviews = (clone $q)->whereRelation('category', 'slug', 'reviews')->limit(3)->get();
        $latestGuides = (clone $q)->whereRelation('category', 'slug', 'guides')->limit(2)->get();
        $latestNews = (clone $q)->whereRelation('category', 'slug', 'top-lists')->limit(2)->get();
        $authors = Author::get();

        return view('index', compact('page', 'authors', 'latestReviews', 'latestGuides', 'latestNews'));
    }
}
