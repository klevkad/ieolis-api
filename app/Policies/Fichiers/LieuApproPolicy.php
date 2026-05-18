<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\LieuAppro;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LieuApproPolicy
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
        return $user->hasPermissionTo('lieuapproindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return mixed
     */
    public function view(User $user, LieuAppro $lieuAppro)
    {
        return $user->hasPermissionTo('lieuapproshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('lieuapprocreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return mixed
     */
    public function update(User $user, LieuAppro $lieuAppro)
    {
        return $user->hasPermissionTo('lieuapproupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return mixed
     */
    public function delete(User $user, LieuAppro $lieuAppro)
    {
        return $user->hasPermissionTo('lieuapprodelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return mixed
     */
    public function restore(User $user, LieuAppro $lieuAppro)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return mixed
     */
    public function forceDelete(User $user, LieuAppro $lieuAppro)
    {
        //
    }
}
