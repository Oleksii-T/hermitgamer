<?php

namespace App\Http\Requests\Admin;

use App\Enums\PostStatus;
use App\Enums\PostTCStyle;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $model = $this->route('post');

        return [
            'parent_id' => ['nullable', 'exists:posts,id'],
            'title' => ['required', 'string', 'max:255'],
            'intro' => ['nullable', 'string'],
            'slug' => ['required', 'string', 'max:255'],
            'thumbnail' => [$model ? 'nullable' : 'required', 'image', 'max:5000'],
            'status' => ['required', Rule::in(PostStatus::values())],
            'tc_style' => ['required', Rule::in(PostTCStyle::values())],
            'category_id' => ['nullable', 'exists:categories,id'],
            'game_id' => ['nullable', 'exists:games,id'],
            'author_id' => ['required', 'exists:authors,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'exists:tags,id'],
        ];
    }
}
