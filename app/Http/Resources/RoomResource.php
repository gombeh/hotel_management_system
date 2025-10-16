<?php

namespace App\Http\Resources;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this Room | RoomResource */
        return [
            'id' => $this->id,
            'room_number' => $this->room_number,
            'floor_number' => $this->floor_number,
            'status' => $this->status,
            'smoking_preference' => $this->smoking_preference,
            'type' => RoomTypeResource::make($this->whenLoaded('type')),
            'access' => $this->whenNotNull($this->access)
        ];
    }
}
