<?php

namespace App\Http\Requests\Admin\MealPlan;

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
            'name' => 'required|string|unique:meal_plans,name,' . $this->mealPlan->id,
            'code' => 'required|string|unique:meal_plans,code,' . $this->mealPlan->id,
            'description' => 'nullable',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'required|numeric|min:0',
            'infant_price' => 'required|numeric|min:0',
        ];
    }

}
