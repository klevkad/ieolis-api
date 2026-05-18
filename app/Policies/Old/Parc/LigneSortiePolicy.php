<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\LigneSortie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LigneSortiePolicy
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
        return $user->hasPermissionTo('ligneSortieindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\LigneSortie  $ligneSortie
     * @return mixed
     */
    public function view(User $user, LigneSortie $ligneSortie)
    {
        return $user->hasPermissionTo('ligneSortieshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('ligneSortiecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\LigneSortie  $ligneSortie
     * @return mixed
     */
    public function update(User $user, LigneSortie $ligneSortie)
    {
        return $user->hasPermissionTo('ligneSortieupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\LigneSortie  $ligneSortie
     * @return mixed
     */
    public function delete(User $user, LigneSortie $ligneSortie)
    {
        return $user->hasPermissionTo('ligneSortiedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\LigneSortie  $ligneSortie
     * @return mixed
     */
    public function restore(User $user, LigneSortie $ligneSortie)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\LigneSortie  $ligneSortie
     * @return mixed
     */
    public function forceDelete(User $user, LigneSortie $ligneSortie)
    {
        //
    }
}
