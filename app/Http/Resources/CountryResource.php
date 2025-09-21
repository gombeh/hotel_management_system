<?php

namespace App\Http\Resources;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       /** @var $this Country | CountryResource */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short' => $this->short,
            'can' => $this->whenNotNull($this->can)
        ];
    }
}
