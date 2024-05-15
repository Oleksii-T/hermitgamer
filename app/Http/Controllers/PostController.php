<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Page;
use App\Enums\PostStatus;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Request $request, Post $post)
    {
        $user = auth()->user();

        if ($post->status == PostStatus::DRAFT && !$user) {
            abort(404);
        }

        $page = Page::get('{post}');
        $author = $post->author;
        $game = $post->game;
        $category = $post->category;
        $relatedPosts = $post->getRelatedPosts();
        $blockGroups = $post->getGroupedBlocks();
        $sameGamePosts = Post::query()
            ->publised()
            ->whereNull('parent_id')
            ->where('game_id', $post->game_id)
            ->with('childs')
            ->latest()
            ->get();

        return view('posts.show', compact('post', 'page', 'author', 'game', 'category', 'relatedPosts', 'sameGamePosts', 'blockGroups'));
    }

    public function view(Request $request, Post $post)
    {
        $post->saveView();
    }
}
