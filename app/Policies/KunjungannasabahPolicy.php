<?php

namespace App\Policies;

use App\Models\Kunjungannasabah;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KunjungannasabahPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin','adminpanel','userao']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Kunjungannasabah $kunjungannasabah): bool
    {
        return $user->hasRole(['admin','adminpanel','userao']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['userao']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Kunjungannasabah $kunjungannasabah): bool
    {
        return $user->hasRole(['adminpanel','admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Kunjungannasabah $kunjungannasabah): bool
    {
        return $user->hasRole(['adminpanel','admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Kunjungannasabah $kunjungannasabah): bool
    {
        return $user->hasRole(['adminpanel','admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Kunjungannasabah $kunjungannasabah): bool
    {
        return $user->hasRole(['adminpanel','admin']);
    }
}
