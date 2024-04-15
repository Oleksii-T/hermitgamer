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
            'ganres' => ['required', 'string', 'max:255'],
            'thumbnail' => [$reqNull, 'file', 'max:5000'],
            'description' => ['required', 'string', 'max:10000'],
            'summary' => ['required', 'string', 'max:10000'],
            'esbr' => ['required', 'string', 'max:10000'],
            'esbr_image' => [$reqNull, 'file', 'max:5000'],
            'hours' => ['required', 'array'],
            'hours.main' => ['required', 'numeric'],
            'hours.main_sides' => ['required', 'numeric'],
            'hours.completionist' => ['required', 'numeric'],
            'hours.all' => ['required', 'numeric'],
        ];
    }
}
