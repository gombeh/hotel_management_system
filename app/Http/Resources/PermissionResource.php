<?php

namespace App\Http\Resources;

use App\Services\Permission\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this Role | RoleResource */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'translate' => PermissionService::translate($this->name),
        ];
    }
}
