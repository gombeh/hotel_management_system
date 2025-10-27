<?php

namespace App\Http\Requests\Admin\Booking;

use App\Enums\SmokingPreference;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PricesRequest extends FormRequest
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
            'rooms' => 'required|array|min:1',
            'rooms.*' => 'required|array',
            'rooms.*.type_id' => 'required|integer|exists:room_types,id',
            'rooms.*.quantity' => 'required|integer|min:1',
            'meal_plan_id' => 'required|integer|exists:meal_plans,id',
            'children_age' => 'nullable|array|min:0',
            'children_age.*' => 'required|array',
            'children_age.*.age' => 'required|integer|min:0|max:12',
            'nights' => 'required|integer|min:1',
        ];
    }

}
