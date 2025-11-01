<?php

namespace App\Http\Requests\Admin\Booking;

use App\Enums\SmokingPreference;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0|',
            'check_in' => [
                'required'
                ,'date',
                Rule::date()->todayOrAfter(),
                function($attribute, $value, $fail) {
                    if ($this->check_in_now && $value !== date('Y-m-d')) {
                        $fail('Check-in must be today when "check_in_now" is selected.');
                    }
                },
            ],
            'check_out' => 'required|date|after:check_in',
            'customer_id' => 'required|integer|exists:customers,id',
            'smoking_preference' => 'required|string|in:' . SmokingPreference::asString(),
            'rooms' => 'required|array|min:1',
            'rooms.*' => 'required|array',
            'rooms.*.type_id' => 'required|integer|exists:room_types,id',
            'rooms.*.quantity' => 'required|integer|min:1',
            'meal_plan_id' => 'required|integer|exists:meal_plans,id',
            'special_requests' => 'nullable',
            'check_in_now' => 'required|boolean',
            'children_age' => 'nullable|array|min:0',
            'children_age.*' => 'required|array',
            'children_age.*.age' => 'required|integer|min:0|max:12',
        ];
    }

}
