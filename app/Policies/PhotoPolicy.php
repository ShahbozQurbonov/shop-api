<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PhotoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Photo $photo): bool
    {
        return $this->isOwner($user, $photo);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Photo $photo): bool
    {
        return $this->isOwner($user, $photo);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Photo $photo): bool
    {
        return $this->isOwner($user, $photo);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Photo $photo): bool
    {
        return $this->isOwner($user, $photo);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Photo $photo): bool
    {
        //
    }

    private function isOwner(User $user, Photo $photo): bool
    {
        // Агар photo ба User тааллуқ дорад
        if ($photo->photoable_type === User::class) {
            return $photo->photoable_id === $user->id;
        }

        // Агар photo ба Product тааллуқ дорад
        if ($photo->photoable_type === \App\Models\Product::class) {
            // Агар product owner дошта бошад (мисол user_id)
            return optional($photo->photoable)->user_id === $user->id;
        }

        return false;
    }
}
