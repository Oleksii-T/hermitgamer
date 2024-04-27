<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
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
        $model = $this->route('game');
        $reqNull = $model ? 'nullable' : 'required';

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'metacritic' => ['nullable', 'integer', 'min:0', 'max:100'],
            'users_score' => ['required', 'numeric', 'min:0', 'max:10'],
            'release_date' => ['required', 'string', 'max:255'],
            'developer' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'platforms' => ['required', 'string', 'max:255'],
            'ganres' => ['required', 'string'],
            'thumbnail' => [$reqNull, 'array'],
            'thumbnail.file' => [$reqNull, 'file', 'max:5000'],
            'thumbnail.alt' => [$reqNull, 'string', 'max:255'],
            'thumbnail.title' => [$reqNull, 'string', 'max:255'],
            'thumbnail.id' => ['nullable', 'integer'],
            'meta_thumbnail' => [$reqNull, 'array'],
            'meta_thumbnail.file' => [$reqNull, 'file', 'max:5000'],
            'meta_thumbnail.alt' => [$reqNull, 'string', 'max:255'],
            'meta_thumbnail.title' => [$reqNull, 'string', 'max:255'],
            'meta_thumbnail.id' => ['nullable', 'integer'],
            'description' => ['required', 'string', 'max:10000'],
            'summary' => ['required', 'string', 'max:10000'],
            'esbr' => ['required', 'string', 'max:10000'],
            'esbr_image' => [$reqNull, 'array'],
            'esbr_image.file' => [$reqNull, 'file', 'max:5000'],
            'esbr_image.alt' => [$reqNull, 'string', 'max:255'],
            'esbr_image.title' => [$reqNull, 'string', 'max:255'],
            'esbr_image.id' => ['nullable', 'integer'],
            'hours' => ['required', 'array'],
            'hours.main' => ['required', 'numeric'],
            'hours.main_sides' => ['required', 'numeric'],
            'hours.completionist' => ['required', 'numeric'],
            'hours.all' => ['required', 'numeric'],
            'screenshots' => ['nullable', 'array'],
            'screenshots.file' => ['nullable', 'array'],
            'screenshots.file.*' => ['nullable', 'file', 'max:5000'],
            'screenshots.alt' => ['nullable', 'array'],
            'screenshots.alt.*' => ['nullable', 'string', 'max:255'],
            'screenshots.title' => ['nullable', 'array'],
            'screenshots.title.*' => ['nullable', 'string', 'max:255'],
            'screenshots.id' => ['nullable', 'array'],
            'screenshots.id.*' => ['nullable', 'integer'],
        ];
    }
}
