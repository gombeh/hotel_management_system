<?php

namespace App\Http\Requests\Admin\Booking\Payment;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Rules\PriceLessThanTotal;
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
            'amount' => [
                'bail',
                'required',
                'numeric',
                'min:1',
                new PriceLessThanTotal($this->payment->booking, $this->payment->id)
            ],
            'payment_method' => 'required|string|in:' . PaymentMethod::asString(),
            'status' => 'required|string|in:' . PaymentStatus::asString(),
            'reference' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }

}
