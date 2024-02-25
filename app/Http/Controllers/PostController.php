<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function show(Request $request, Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function more(Request $request)
    {
        $request->validate([
            'page' => ['required', 'integer', 'min:1'],
            'category' => ['required', 'string', 'max:50'],
        ]);

        $perPage = 6;
        $page = $request->page ?? 0;
        $isLast = false;

        $posts = Post::query()
            ->active()
            ->category($request->category)
            ->latest()
            ->offset($perPage * $page)
            ->limit($perPage)
            ->get();

        if ($posts->count() < $perPage) {
            $isLast = true;
        }

        //todo: check next page to prevent empty page load

        return $this->jsonSuccess('', [
            'posts' => view('components.posts.news', ['news' => $posts])->render(),
            'isLast' => $isLast
        ]);
    }

    public function view(Request $request, Post $post)
    {
        $post->saveView();
    }
}
