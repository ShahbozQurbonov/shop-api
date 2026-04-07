<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Value;
use Illuminate\Auth\Access\Response;

class ValuePolicy
{
       public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Value $value): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('value:create');
    }

    public function update(User $user, Value $value): bool
    {
        return $user->can('value:update');
    }

    public function delete(User $user, Value $value): bool
    {
        return $user->can('value:delete');
    }

    public function restore(User $user, Value $value): bool
    {
        return false;
    }

    public function forceDelete(User $user, Value $value): bool
    {
        return false;
    }
}
