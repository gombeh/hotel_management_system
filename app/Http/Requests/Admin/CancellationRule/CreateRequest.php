<?php

namespace App\Http\Requests\Admin\CancellationRule;

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
            'min_days_before' => 'required|integer|min:0',
            'max_days_before' => 'required|integer|min:0',
            'penalty_percent' => 'required|integer|min:0',
            'description' => 'nullable',
        ];
    }

}
