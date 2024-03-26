<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show(Request $request, Author $author)
    {
        // $author = Author::where('slug', $slug)->firstOrFail();
        $perPage = 5;
        $posts = $author->posts()->publised()->latest()->paginate($perPage);

        if (!$request->ajax()) {
            $page = Page::get('author');
            return view('authors.show', compact('author', 'posts', 'page'));
        }

        return $this->jsonSuccess('', [
            'hasMore' => $posts->hasMorePages(),
            'html' => view('components.post-cards', compact('posts'))->render()
        ]);
    }
}
