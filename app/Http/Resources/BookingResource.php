<?php

namespace App\Http\Resources;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this Booking | BookingResource */
        return [
            'id' => $this->id,
            'ref_number' => $this->ref_number,
            'adults' => $this->adults,
            'children' => $this->children,
            'check_in' => $this->check_in->format('Y-m-d'),
            'check_out' => $this->check_out->format('Y-m-d'),
            'smoking_preference' => $this->smoking_preference,
            'status' => $this->status,
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'mealPlan' => MealPlanResource::make($this->whenLoaded('mealPlan')),
            'rooms' => RoomResource::collection($this->whenLoaded('rooms')),
            'statuses' => BookingStatusResource::collection($this->whenLoaded('statuses')),
            'special_requests' => $this->special_requests,
            'total_price' => $this->total_price,
            'partial_amount' => $this->partial_amount,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'access' => $this->whenNotNull($this->access),
        ];
    }
}
