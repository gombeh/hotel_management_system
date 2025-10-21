<?php

namespace App\Http\Resources;

use App\Models\RoomType;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'short_description' => Str::words($this->description, 15, '...'),
            'description' => $this->description,
            'size' => $this->size,
            'max_adult' => $this->max_adult,
            'max_children' => $this->max_children,
            'max_total_guests' => $this->max_total_guests,
            'price' => $this->price,
            'extra_bed_price' => $this->extra_bed_price,
            'status' => $this->status,
            'mainImage' => MediaService::resource($this, 'main'),
            'gallery' => $request->routeIs(['roomTypes.show', 'admin.roomTypes.*'])
                ? MediaService::resource($this, 'gallery')
                : null,
            'facilities' => FacilityResource::collection($this->whenLoaded('facilities')),
            'bedTypes' => BedTypeResource::collection($this->whenLoaded('bedTypes')),
            'access' => $this->whenNotNull($this->access),
            'rooms_count' => $this->whenNotNull($this->rooms_count),
        ];
    }
}
