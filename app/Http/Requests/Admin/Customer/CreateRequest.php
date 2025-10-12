<?php

namespace App\Http\Requests\Admin\Customer;

use App\Enums\CustomerStatus;
use App\Enums\Sex;
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
            'email' => 'required|string|email|unique:customers,email',
            'mobile' => 'nullable|numeric|unique:customers,mobile',
            'password' => ['required', 'string', 'max:255'],
            'sex' => ['nullable', 'string', 'in:'. Sex::asString()],
            'status' => ['required', 'string', 'in:' . CustomerStatus::asString()]
        ];
    }

}
