<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "full_name" => $this->last_name . ' ' . $this->first_name,
            "email" => $this->email,
            "phone" => $this->phone,
            "settings" => UserSettingResource::collection($this->settings),
            // "roles" => $this->getRoleNames(),
            "roles" => $this->getRoleNames()->map(function ($roleName) {
            $role = Role::where('name', $roleName)->first();

            return [
                'name' => $roleName,
                'permissions' => $role ? $role->permissions->pluck('name') : []
            ];
        }),
            "photo" => PhotoResource::collection($this->photos),
            "created_at" => $this->created_at,
        ];
    }
}
