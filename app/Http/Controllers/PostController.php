<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Page;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Request $request, Post $post)
    {
        $page = Page::get('post');
        $author = $post->author;
        $game = $post->game;
        $category = $post->category;
        $relatedPosts = $post->getRelatedPosts();
        $sameGamePosts = Post::whereNull('parent_id')->where('game_id', $post->game_id)->with('childs')->latest()->get();
        $blockGroups = $post->getGroupedBlocks();

        return view('posts.show', compact('post', 'page', 'author', 'game', 'category', 'relatedPosts', 'sameGamePosts', 'blockGroups'));
    }

    public function view(Request $request, Post $post)
    {
        $post->saveView();
    }
}
