<?php

namespace App\Http\Resources;

use App\Models\BookingCharge;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingChargeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this BookingCharge | BookingChargeResource */
        return [
            'id' => $this->id,
            'charge_type' => $this->charge_type,
            'amount' => $this->amount,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
