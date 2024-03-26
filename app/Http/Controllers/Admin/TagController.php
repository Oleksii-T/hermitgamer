<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\Admin\TagRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.tags.index');
        }

        $tags = Tag::query();

        return Tag::dataTable($tags);
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(TagRequest $request)
    {
        $input = $request->validated();
        if (!($input['order']??null)) {
            $input['order'] = Tag::max('order') + 1;
        }
        $tag = Tag::create($input);
        $tag->saveTranslations($input);
        Tag::getAllSlugs(true);

        return $this->jsonSuccess('Tag created successfully', [
            'redirect' => route('admin.tags.index')
        ]);
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $input = $request->validated();

        $tag->update($input);
        Tag::getAllSlugs(true);

        return $this->jsonSuccess('Tag updated successfully');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return $this->jsonSuccess('Tag deleted successfully');
    }
}
