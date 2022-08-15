<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
use Laravel\Fortify\Rules\Password;
use App\Actions\Fortify\PasswordValidationRules;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;

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
        $model = $this->route('user');
        if ($model) {
            $emailRule = Rule::unique(User::class)->ignore($model->email, 'email');
            $passRule = $this->passwordRules(false);
        } else {
            $emailRule = Rule::unique(User::class);
            $passRule = $this->passwordRules();
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', $emailRule],
            'password' => $passRule,
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'exists:roles,id'],
        ];
    }
}
