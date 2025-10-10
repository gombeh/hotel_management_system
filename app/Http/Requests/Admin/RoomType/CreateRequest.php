<?php

namespace App\Http\Requests\Admin\RoomType;

use App\Enums\RoomTypeStatus;
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
            'name' => 'required|string|unique:room_types,name',
            'slug' => 'required|string|unique:room_types,slug',
            'view' => 'required|string',
            'size' => 'required|integer',
            'max_adult' => 'required|integer|min:1',
            'max_children' => 'required|integer|min:0',
            'max_total_guests' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'extra_bed_price' => 'required|integer|min:0',
            'facilities' => 'required|array',
            'facilities.*' => 'required|exists:facilities,id',
            'bedTypes' => 'required|array',
            'bedTypes.*' => 'required|array',
            'bedTypes.*.id' => 'required|exists:bed_types,id',
            'bedTypes.*.quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'mainImage' => 'required|array|size:1',
            'gallery' => 'nullable|array',
            'status' => 'required|in:'. RoomTypeStatus::asString(),
        ];
    }

}
