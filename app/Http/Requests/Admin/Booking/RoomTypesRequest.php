<?php

namespace App\Http\Requests\Admin\Booking;

use App\Enums\SmokingPreference;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomTypesRequest extends FormRequest
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
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'check_in' => ['required','date', Rule::date()->todayOrAfter()],
            'check_out' => 'required|date|after:check_in',
            'smoking_preference' => 'required|string|in:' . SmokingPreference::asString(),
            'children_age' => 'nullable|array|min:0',
            'children_age.*' => 'required|array',
            'children_age.*.age' => 'required|integer|min:0|max:12',
        ];
    }

}
