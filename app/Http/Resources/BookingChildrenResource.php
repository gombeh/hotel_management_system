<?php

namespace App\Http\Resources;

use App\Models\BookingChildren;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingChildrenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this BookingChildren | BookingChildrenResource */
        return [
            'id' => $this->id,
            'age' => $this->age,
        ];
    }
}
