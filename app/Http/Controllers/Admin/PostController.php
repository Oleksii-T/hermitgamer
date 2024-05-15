<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\Post;
use App\Models\BlockItem;
use App\Enums\PostStatus;
use App\Enums\BlockItemType;
use Illuminate\Http\Request;
use App\Actions\GenerateSitemap;
use Illuminate\Http\UploadedFile;
use App\Actions\SaveContentBlocks;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.posts.index');
        }

        $posts = Post::query()
            ->when($request->trashed, fn ($q) => $q->onlyTrashed())
            ->when($request->category, fn ($q) => $q->where('category_id', $request->category))
            ->when($request->game, fn ($q) => $q->where('game_id', $request->game))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->author, fn ($q) => $q->where('author_id', $request->author));

        return Post::dataTable($posts);
    }

    public function create()
    {
        $parents = Post::whereNull('parent_id')->get();

        return view('admin.posts.create', compact('parents'));
    }

    public function store(PostRequest $request)
    {
        $input = $request->validated();
        if ($input['status'] == PostStatus::PUBLISHED->value) {
            $input['published_at'] = now();
        }
        $input['intro'] = sanitizeHtml($input['intro']);
        $post = Post::create($input);
        $post->addAttachment($input['thumbnail']??null, 'thumbnail');

        Post::getAllSlugs(true);
        GenerateSitemap::run();

        return $this->jsonSuccess('Post created successfully', [
            'redirect' => route('admin.posts.blocks', $post)
        ]);
    }

    public function recover(Request $request, $id)
    {
        $post = Post::withTrashed()->where('slug', $id)->firstOrFail();
        $post->deleted_at = null;
        $post->slug = makeSlug($post->slug, Post::pluck('slug')->toArray());
        $post->save();

        return redirect()->back();
    }

    public function blocks(Post $post)
    {
        $blocks = $post->blocks()->with('items')->get();
        $blocksA = $blocks->toArray();
        $appData = json_encode([
            'itemTypes' => BlockItemType::all(),
            'model' => [
                'id' => $post->id,
                'block_groups' => $post->block_groups,
                'blocks' => $blocksA
            ],
            'submitUrl' => route('admin.posts.update-blocks', $post),
        ]);

        return view('admin.posts.blocks', compact('appData', 'post'));
    }

    public function updateBlocks(Request $request, Post $post)
    {
        $request->validate([
            'group_blocks' => ['required', 'array'],
            'blocks' => ['required', 'array', new \App\Rules\ValidBlocksRule],
            // 'blocks.*.ident' => ['required', 'string', 'max:255'],
            // 'blocks.*.name' => ['required', 'string', 'max:255'],
            // 'blocks.*.items' => ['required', 'array'],
            // 'blocks.*.items.*' => ['required', 'array'],
        ]);

        if (array_sum($request->group_blocks) != count($request->blocks)) {
            abort(422, 'Invalid groups');
        }

        \DB::transaction(fn () => SaveContentBlocks::run($post, $request));

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

        $data['answer'] = sanitizeHtml($data['answer']);
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
        $data['answer'] = sanitizeHtml($data['answer']);

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

        $input['conclusion'] = sanitizeHtml($input['conclusion']);
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
            'related' => $input['related']??[]
        ]);

        return $this->jsonSuccess('Related updated successfully', [
            'reload' => true
        ]);
    }

    public function edit(Post $post)
    {
        $parents = Post::whereNull('parent_id')->get();

        return view('admin.posts.edit', compact('post', 'parents'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $input = $request->validated();
        $publishedStatuses = [PostStatus::PUBLISHED->value, PostStatus::HIDDEN->value];

        if (in_array($input['status'], $publishedStatuses) && !in_array($post->status, $publishedStatuses)) {
            $input['published_at'] = now();
        }

        $input['intro'] = sanitizeHtml($input['intro']);

        $post->update($input);
        $post->addAttachment($input['thumbnail']??null, 'thumbnail');
        $post->addAttachment($input['css']??null, 'css');
        $post->addAttachment($input['js']??null, 'js');
        $post->addAttachment($input['images']??[], 'images');

        Post::getAllSlugs(true);
        GenerateSitemap::run();

        return $this->jsonSuccess('Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return $this->jsonSuccess('Post deleted successfully');
    }

    private function addSpans($html)
    {
        $dom = new \DOMDocument;
        $html = str_replace('&nbsp;', '', $html);
        $html = str_replace('<p></p>', '', $html);
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $xpath = new \DOMXPath($dom);

        $tds = $xpath->query('//td');

        foreach ($tds as $td) {
            // Remove 'br' elements
            $brs = $td->getElementsByTagName('br');
            for ($i = $brs->length - 1; $i >= 0; $i--) {
                $brs->item($i)->parentNode->removeChild($brs->item($i));
            }
            // Unwrap 'p' elements
            foreach ($td->getElementsByTagName('p') as $p) {
                while ($p->childNodes->length > 0) {
                    $p->parentNode->insertBefore($p->childNodes->item(0), $p);
                }
                $p->parentNode->removeChild($p);
            }
            // Wrap text nodes in 'span' elements
            foreach ($td->childNodes as $child) {
                $nodeValue = trim($child->nodeValue);
                if ($child instanceof \DOMText && $nodeValue) {
                    $span = $dom->createElement('span', $nodeValue);
                    $td->replaceChild($span, $child);
                }
            }
        }

        // Wrap 'b' elements inside 'td' elements with 'span' elements
        $bs = $xpath->query('//td/b[not(parent::span)]');
        foreach ($bs as $b) {
            $span = $dom->createElement('span');
            $b->parentNode->replaceChild($span, $b);
            $span->appendChild($b);
        }

        $newHtml = $dom->saveHTML();

        return $newHtml;
    }
}
