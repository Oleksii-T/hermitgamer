<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Http\Requests\Admin\AuthorRequest;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.authors.index');
        }

        $authors = Author::query();

        return Author::dataTable($authors);
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(AuthorRequest $request)
    {
        $input = $request->validated();
        $author = Author::create($input);
        $author->addAttachment($input['avatar'], 'avatar');
        Author::getAllSlugs(true);

        return $this->jsonSuccess('Author created successfully', [
            'redirect' => route('admin.authors.index')
        ]);
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $input = $request->validated();

        $author->update($input);
        $author->addAttachment($input['avatar']??false, 'avatar');
        Author::getAllSlugs(true);

        return $this->jsonSuccess('Author updated successfully');
    }

    public function socials(Author $author)
    {
        return view('admin.authors.socials', compact('author'));
    }

    public function updateSocials(Request $request, Author $author)
    {
        $data = $request->validate([
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'steam' => ['nullable', 'string', 'max:255'],
        ]);

        $author->update($data);

        return $this->jsonSuccess('Socials updated successfully');
    }

    public function paragraphs(Author $author)
    {
        return view('admin.authors.paragraphs', compact('author'));
    }

    public function updateParagraphs(Request $request, Author $author)
    {
        $data = $request->validate([
            'titles' => ['nullable', 'array'],
            'texts' => ['nullable', 'array'],
        ]);

        $author->paragraphs()->delete();

        foreach ($data['titles'] as $i => $title) {
            $desc = $data['texts'][$i] ?? '';
            if (!$title || !$desc) {
                continue;
            }

            $author->paragraphs()->create([
                'title' => $title,
                'text' => $desc
            ]);
        }

        return $this->jsonSuccess('Socials updated successfully');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return $this->jsonSuccess('Author deleted successfully');
    }
}
