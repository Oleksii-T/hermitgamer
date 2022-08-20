<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\BlockItem;
use App\Http\Requests\Admin\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

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
        return view('admin.posts.create');
    }

    public function store(PostRequest $request)
    {
        $input = $request->validated();
        $post = Post::create($input);
        $post->saveTranslations($input);
        $post->addAttachment($input['thumbnail']??null, 'thumbnail');
        $post->addAttachment($input['css']??null, 'css');
        $post->addAttachment($input['js']??null, 'js');

        return $this->jsonSuccess('Post created successfully', [
            'redirect' => route('admin.posts.edit-content', $post)
        ]);
    }

    public function editContent(Post $post)
    {
        //TODO: move logic to "Eloquent: API Resource"
        $blocks = $post->blocks()->with('items')->get();
        $blocksA = $blocks->toArray();
        foreach ($blocksA as $i => $block) {
            $blocksA[$i]['name'] = $blocks->where('id', $block['id'])->first()->translatedFull('name', true);
        }

        $appData = json_encode([
            'locales' => \LaravelLocalization::getLocalesOrder(),
            'itemTypes' => BlockItem::TYPES,
            'post' => [
                'id' => $post->id,
                'blocks' => $blocksA
            ]
        ]);

        return view('admin.posts.edit-content', compact('appData', 'post'));
    }

    public function updateContent(Request $request, Post $post)
    {
        $request->validate([
            'blocks' => ['required', 'array'],
            'blocks.*.ident' => ['required', 'string', 'max:255'],
            'blocks.*.name' => ['required', 'array'],
            'blocks.*.name.en' => ['required', 'string', 'max:255'],
            'blocks.*.items' => ['required', 'array'],
            'blocks.*.items.*' => ['required', 'array'],
        ]);

        foreach ($request->blocks as $b) {
            $block = $post->blocks()->updateOrcreate(
                [
                    'id' => $b['id']??null
                ],
                [
                    'ident' => $b['ident'],
                    'order' => $b['order']
                ]
            );
            $block->saveTranslations($b);
            foreach ($b['items'] as $i) {
                $item = $block->items()->updateOrCreate(
                    [
                        'id' => $i['id']??null
                    ],
                    [
                        'type' => $i['type'],
                        'order' => $i['order']
                    ]
                );
                if ($item['type'] == 'title') {
                    $item->saveTranslation($i['value'], 'title');
                } elseif ($item['type'] == 'text') {
                    $item->saveTranslation($i['value'], 'text');
                } elseif ($item['type'] == 'image') {
                    if ($i['value'] instanceof UploadedFile) {
                        $item->addAttachment($i['value']);
                    }
                } elseif ($item['type'] == 'video') {
                    if ($i['value'] instanceof UploadedFile) {
                        $item->addAttachment($i['value']);
                    }
                } elseif ($item['type'] == 'slider') {
                    foreach ($i['value'] as $sliderImage) {
                        if ($sliderImage instanceof UploadedFile) {
                            $item->addAttachment($sliderImage);
                        }
                    }
                }
            }
        }

        return $this->jsonSuccess('Post content saved successfully', $post);
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
