<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\Admin\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.comments.index');
        }

        $comments = Comment::query();

        return Comment::dataTable($comments);
    }

    public function create()
    {
        return view('admin.comments.create');
    }

    public function store(CommentRequest $request)
    {
        $input = $request->validated();
        $comment = Comment::create($input);
        $comment->saveTranslations($input);

        return $this->jsonSuccess('Comment created successfully', [
            'redirect' => route('admin.comments.index')
        ]);
    }

    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $input = $request->validated();
        $comment->update($input);
        $comment->saveTranslations($input);

        return $this->jsonSuccess('Comment updated successfully');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return $this->jsonSuccess('Comment deleted successfully');
    }
}
