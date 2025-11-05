<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        /** @var $this User | UserResource */
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'sex' => $this->sex,
            'full_name' => $this->full_name,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'avatar' => MediaService::resource($this, 'avatar'),
            'access' => $this->whenNotNull($this->access),
        ];
    }
}
