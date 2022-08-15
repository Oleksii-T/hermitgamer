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
        return [
            'name' => ['required', 'array'],
            'name.en' => ['required', 'string', 'max:255'],
            'name.*' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'array'],
            'slug.en' => ['required', 'string', 'max:255'],
            'slug.*' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'array'],
            'description.en' => ['required', 'string', 'max:10000'],
            'description.*' => ['nullable', 'string', 'max:10000'],
        ];
    }
}
