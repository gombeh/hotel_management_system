<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this Customer | CustomerResource */
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'national' => CountryResource::make($this->whenLoaded('national')),
            'email' => $this->email,
            'mobile' => $this->mobile,
            'email_verified_at' => $this->email_verified_at,
            'mobile_verified_at' => $this->mobile_verified_at,
            'sex' => $this->sex,
            'birthdate' => $this->birthdate,
            'status' => $this->status,
            'avatar' => !empty($this->getFirstMediaUrl('avatar')) ? $this->getFirstMediaUrl('avatar') : \Storage::url('avatar/default.png'), //todo better then
            'access' => $this->whenNotNull($this->access ?? null)
        ];
    }
}
