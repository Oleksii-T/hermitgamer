<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\BlockItem;
use App\Http\Requests\Admin\PostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.posts.index');
        }

        $posts = Post::query();

        if ($request->category !== null) {
            $posts->where('category_id', $request->category);
        }
        if ($request->author !== null) {
            $posts->where('author_id', $request->author);
        }
        if ($request->game !== null) {
            $posts->where('game_id', $request->game);
        }

        return Post::dataTable($posts);
    }

    public function create()
    {
        $itemTypes = BlockItem::TYPES;

        return view('admin.posts.create', compact('itemTypes'));
    }

    public function store(Request $request)
    {
        $input = $request->validated();
        $post = Post::create($input);
        $post->saveTranslations($input);
        $post->addAttachment($input['thumbnail']??null, 'thumbnail');
        $post->addAttachment($input['css']??null, 'css');
        $post->addAttachment($input['js']??null, 'js');
        $post->addAttachment($input['images']??[], 'images');

        return $this->jsonSuccess('Post created successfully', [
            'redirect' => route('admin.posts.index')
        ]);
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $input = $request->validated();
        $post->update($input);
        $post->saveTranslations($input);
        $post->addAttachment($input['thumbnail']??null, 'thumbnail');
        $post->addAttachment($input['css']??null, 'css');
        $post->addAttachment($input['js']??null, 'js');
        $post->addAttachment($input['images']??[], 'images');

        return $this->jsonSuccess('Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return $this->jsonSuccess('Post deleted successfully');
    }
}
