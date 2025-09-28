<?php

namespace App\Http\Resources;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this RoomType | RoomTypeResource */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'view' => $this->view,
            'description' => $this->description,
            'size' => $this->size,
            'max_adult' => $this->max_adult,
            'max_children' => $this->max_children,
            'max_total_guests' => $this->max_total_guests,
            'price' => $this->price,
            'status' => $this->status,
            'gallery' => MediaResource::collection($this->getMedia('gallery')),
            'can' => $this->whenNotNull($this->can),
        ];
    }
}
