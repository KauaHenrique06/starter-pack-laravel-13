<?php

namespace App\Policies\User;

use App\Models\User;

/**
 * Permissions (user.view, user.create, ...) are checked on the route middleware.
 * The policy only decides which records the user can act on: admin acts on any, others only on themselves.
 */
class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     * Obs: index
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     * Obs: show
     */
    public function view(User $authUser, User $user): bool
    {
        return $authUser->hasRole('admin') || $authUser->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $user): bool
    {
        return $authUser->hasRole('admin') || $authUser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $user): bool
    {
        return $authUser->hasRole('admin') || $authUser->id === $user->id;
    }
}
