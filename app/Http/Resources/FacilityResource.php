<?php

namespace App\Http\Resources;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this Facility | FacilityResource */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => MediaResource::collection($this->getMedia()),
            'can' => $this->whenNotNull($this->can),
        ];
    }
}
