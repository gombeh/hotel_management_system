<?php

namespace App\Http\Resources;

use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this MealPlan|MealPlanResource */
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'extra_price' => $this->extra_price,
            'can' => $this->whenNotNull($this->can),
        ];
    }
}
