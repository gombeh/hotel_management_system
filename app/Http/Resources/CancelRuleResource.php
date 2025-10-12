<?php

namespace App\Http\Resources;

use App\Models\CancellationRule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CancelRuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this CancellationRule | CancelRuleResource */
        return [
            'id' => $this->id,
            "min_days_before" => $this->min_days_before,
            "max_days_before" => $this->max_days_before,
            "penalty_percent" => $this->penalty_percent,
            "description" => $this->description,
            "can" => $this->whenNotNull($this->can),
        ];
    }
}
