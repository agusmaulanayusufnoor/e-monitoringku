<?php

namespace App\Policies;

use App\Models\Kantor;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Traits\HasRoles;

class KantorPolicy
{
    use HasRoles;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $user = auth()->user();
        if ($user->hasRole("admin"))
            return true;
        else
            return false;


    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Kantor $kantor): bool
    {
        $user = auth()->user();
        if ($user->hasRole("admin"))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $user = auth()->user();
        if ($user->hasRole("admin"))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Kantor $kantor): bool
    {
        $user = auth()->user();
        if ($user->hasRole("admin"))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Kantor $kantor): bool
    {
        $user = auth()->user();
        if ($user->hasRole("admin"))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Kantor $kantor): bool
    {
        $user = auth()->user();
        if ($user->hasRole("admin"))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Kantor $kantor): bool
    {
        $user = auth()->user();
        if ($user->hasRole("admin"))
            return true;
        else
            return false;
    }
}
