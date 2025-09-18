<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|email|unique:users,email',
            'password' => ['required', 'string', 'max:255'],
            'sex' => ['nullable', 'string', 'in:male,female'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['nullable', 'integer', 'exists:roles,id'],
        ];
    }

}
