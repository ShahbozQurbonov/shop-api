<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();
        $canViewSensitiveData = $user
            && ($user->id === $this->id || $user->can('user:view') || $user->can('user:viewAny'));

        return [
            'id' => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "full_name" => $this->last_name . ' ' . $this->first_name,
            "photo" => PhotoResource::collection($this->photos),
            "created_at" => $this->created_at,
            "email" => $canViewSensitiveData ? $this->email : null,
            "phone" => $canViewSensitiveData ? $this->phone : null,
            "settings" => $canViewSensitiveData ? UserSettingResource::collection($this->settings) : [],
            "roles" => $canViewSensitiveData
                ? $this->getRoleNames()->map(function ($roleName) {
                    $role = Role::where('name', $roleName)->first();

                    return [
                        'name' => $roleName,
                        'permissions' => $role ? $role->permissions->pluck('name') : []
                    ];
                })
                : [],
        ];
    }
}
