<?php

namespace App\Http\Resources;

use App\Models\BedType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BedTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this BedType | BedTypeResource */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'capacity' => $this->capacity,
            'quantity' => $this->whenNotNull($this->pivot?->quantity),
            'access' => $this->whenNotNull($this->access),
        ];
    }
}
