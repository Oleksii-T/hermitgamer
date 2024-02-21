<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\BlockItem;
use App\Enums\BlockItemType;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;

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
        $post->addAttachment($input['thumbnail']??null, 'thumbnail');
        $post->addAttachment($input['css']??null, 'css');
        $post->addAttachment($input['js']??null, 'js');

        return $this->jsonSuccess('Post created successfully', [
            'redirect' => route('admin.posts.edit-content', $post)
        ]);
    }

    public function editContent(Post $post)
    {
        $blocks = $post->blocks()->with('items')->get();
        $blocksA = $blocks->toArray();
        foreach ($blocksA as $i => $block) {
            $blocksA[$i]['name'] = $blocks->where('id', $block['id'])->first()->name;
        }

        $appData = json_encode([
            'itemTypes' => BlockItemType::all(),
            'post' => [
                'id' => $post->id,
                'blocks' => $blocksA
            ],
            'submitUrl' => route('admin.posts.update-content', $post),
        ]);

        return view('admin.posts.edit-content', compact('appData', 'post'));
    }

    public function updateContent(Request $request, Post $post)
    {
        $request->validate([
            'blocks' => ['required', 'array'],
            'blocks.*.ident' => ['required', 'string', 'max:255'],
            'blocks.*.name' => ['required', 'string', 'max:255'],
            'blocks.*.items' => ['required', 'array'],
            'blocks.*.items.*' => ['required', 'array'],
        ]);
        
        \DB::transaction(function () use ($request, $post) {
            $simpleValueTypes = BlockItemType::getSimpleTextTypes();
            $simpleFileTypes = BlockItemType::getSimpleFileTypes();

            foreach ($request->blocks as $b) {
                $block = $post->blocks()->updateOrcreate(
                    [
                        'id' => $b['id']??null
                    ],
                    [
                        'ident' => $b['ident'],
                        'order' => $b['order'],
                        'name' => $b['name'],
                    ]
                );

                foreach ($b['items'] as $i) {
                    $t = $i['type'];
                    $v = $i['value'];

                    $item = $block->items()->updateOrCreate(
                        [
                            'id' => $i['id']??null
                        ],
                        [
                            'type' => $t,
                            'order' => $i['order']
                        ]
                    );

                    if (in_array($t, $simpleValueTypes)) {
                        $item->update([
                            'value' => $v
                        ]);
                        continue;
                    } 
                    
                    if (in_array($t, $simpleFileTypes)) {
                        if ($v instanceof UploadedFile) {
                            $item->addAttachment($v);
                        }
                        continue;
                    }

                    if ($t == BlockItemType::IMAGE_TITLE->value) {
                        $item->update([
                            'value' => [
                                'title' => $v['title']
                            ]
                        ]);
                        if ($v['image'] instanceof UploadedFile) {
                            $item->addAttachment($v['image']);
                        }
                        continue;
                    }

                    if ($t == BlockItemType::IMAGE_TEXT->value) {
                        $item->update([
                            'value' => [
                                'text' => $v['text']
                            ]
                        ]);
                        if ($v['image'] instanceof UploadedFile) {
                            $item->addAttachment($v['image']);
                        }
                        continue;
                    }

                    if ($t == BlockItemType::IMAGE_GALLERY->value) {
                        $toAttach = [];
                        foreach ($v['images'] as $sliderImage) {
                            if ($sliderImage['value'] instanceof UploadedFile) {
                                $toAttach[] = $sliderImage['value'];
                            }
                        }
                        if ($toAttach) {
                            $item->addAttachment($toAttach);
                        }
                        continue;
                    }

                    abort(404, 'type not found');
                }
            }
        });

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
