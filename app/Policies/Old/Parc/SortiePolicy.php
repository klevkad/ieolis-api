<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\Sortie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SortiePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('sortieindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return mixed
     */
    public function view(User $user, Sortie $sortie)
    {
        return $user->hasPermissionTo('sortieshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('sortiecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return mixed
     */
    public function update(User $user, Sortie $sortie)
    {
        return $user->hasPermissionTo('sortieupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return mixed
     */
    public function delete(User $user, Sortie $sortie)
    {
        return $user->hasPermissionTo('sortiedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return mixed
     */
    public function restore(User $user, Sortie $sortie)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return mixed
     */
    public function forceDelete(User $user, Sortie $sortie)
    {
        //
    }
}
