<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
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

        return $this->jsonSuccess('Post created successfully', [
            'redirect' => route('admin.posts.blocks', $post)
        ]);
    }

    public function blocks(Post $post)
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
            'submitUrl' => route('admin.posts.update-blocks', $post),
        ]);

        return view('admin.posts.blocks', compact('appData', 'post'));
    }

    public function updateBlocks(Request $request, Post $post)
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
                            $val = $sliderImage['value']??null;
                            if ($val instanceof UploadedFile) {
                                $toAttach[] = $val;
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

    public function faqs(Request $request, Post $post)
    {
        return view('admin.posts.faqs', compact('post'));
    }

    public function storeFaq(Request $request, Post $post)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        $data['order'] = $post->faqs()->max('order') + 1;

        $post->faqs()->create($data);

        return $this->jsonSuccess('FAQ create successfully', [
            'reload' => true
        ]);
    }

    public function updateFaq(Request $request, Post $post, Faq $faq)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'order' => ['required', 'integer'],
        ]);

        $faq->update($data);

        return $this->jsonSuccess('FAQ updated successfully', [
            'reload' => true
        ]);
    }

    public function destroyFaq(Request $request, Post $post, Faq $faq)
    {
        $faq->delete();

        return $this->jsonSuccess('FAQ deleted successfully', [
            'reload' => true
        ]);
    }

    public function assets(Request $request, Post $post)
    {
        return view('admin.posts.assets', compact('post'));
    }

    public function updateAssets(Request $request, Post $post)
    {
        $input = $request->validate([
            'css' => ['nullable', 'file', 'max:10000'],
            'js' => ['nullable', 'file', 'max:10000'],
        ]);

        $post->addAttachment($input['css']??null, 'css');
        $post->addAttachment($input['js']??null, 'js');

        return $this->jsonSuccess('Assets updated successfully', [
            'reload' => true
        ]);
    }

    public function reviewsFields(Request $request, Post $post)
    {
        $info = $post->info;

        if (!$info) {
            $info = $post->info()->create([]);
        }

        return view('admin.posts.reviewsFields', compact('post', 'info'));
    }

    public function updateReviewsFields(Request $request, Post $post)
    {
        $input = $request->validate([
            'info' => ['required', 'array'],
            'info.rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'info.game_details' => ['required', 'array'],
            'info.advantages' => ['required', 'string'],
            'info.disadvantages' => ['required', 'string'],
        ]);

        if ($input['info']['advantages']) {
            $input['info']['advantages'] = explode("\r\n", $input['info']['advantages']);
        }

        if ($input['info']['disadvantages']) {
            $input['info']['disadvantages'] = explode("\r\n", $input['info']['disadvantages']);
        }

        $info = $post->info->update($input['info']);

        return $this->jsonSuccess('Review info updated successfully', [
            'reload' => true
        ]);
    }

    public function conclusion(Request $request, Post $post)
    {
        return view('admin.posts.conclusion', compact('post'));
    }

    public function updateConclusion(Request $request, Post $post)
    {
        $input = $request->validate([
            'conclusion' => ['nullable', 'string'],
        ]);

        $post->update($input);

        return $this->jsonSuccess('Conclusion updated successfully', [
            'reload' => true
        ]);
    }

    public function related(Request $request, Post $post)
    {
        $posts = Post::latest()->where('id', '!=', $post->id)->get();

        return view('admin.posts.related', compact('post', 'posts'));
    }

    public function updateRelated(Request $request, Post $post)
    {
        $input = $request->validate([
            'related' => ['nullable', 'array'],
            'related.*' => ['nullable', 'exists:posts,id'],
        ]);

        $post->update([
            'related' => $input['related']
        ]);

        return $this->jsonSuccess('Related updated successfully', [
            'reload' => true
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
