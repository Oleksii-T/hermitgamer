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
        $reqNull = $model ? 'nullable' : 'required';
        $modelId = $model ? "$model->id,id" : 'NULL,NULL';

        return [
            'parent_id' => ['nullable', 'exists:posts,id'],
            'is_hidden' => ['nullable', 'boolean'],
            'title' => ['required', 'string', 'max:255'],
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:255'],
            'intro' => ['nullable', 'string'],
            'slug' => ['required', 'string', 'max:255', "unique:posts,slug,$modelId,deleted_at,NULL"],
            'thumbnail' => [$reqNull, 'array'],
            'thumbnail.file' => [$reqNull, 'image', 'max:5000'],
            'thumbnail.title' => [$reqNull, 'string', 'max:255'],
            'thumbnail.alt' => [$reqNull, 'string', 'max:255'],
            'thumbnail.id' => ['nullable', 'integer'],
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
