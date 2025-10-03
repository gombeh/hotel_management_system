<?php

namespace App\Http\Requests\Admin\Room;

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
            'room_number' => ['required', 'integer', 'min:1', 'unique:rooms,room_number'],
            'floor_number' => ['required', 'integer', 'min:1'],
            'room_type_id' => ['required', 'integer', 'exists:room_types,id'],
            'status' => ['required', 'string', 'in:available,occupied,maintenance'],
            'smoking_preference' => ['required', 'string', 'in:no_preference,non_smoking,smoking'],
        ];
    }

}
