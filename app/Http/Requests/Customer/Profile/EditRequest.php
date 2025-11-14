<?php

namespace App\Http\Requests\Customer\Profile;

use App\Enums\Sex;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'sex' => ['nullable', 'string', 'in:' . Sex::asString()],
            'avatar' => ['nullable', 'array', 'max:1'],
            'mobile' => ['nullable', 'string', 'min:5', 'max:15'],
            'birthdate' => ['nullable', 'date'],
            'national_id' => ['nullable', 'exists:countries,id'],
         ];
    }

}
