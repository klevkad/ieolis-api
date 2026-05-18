<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\StationEmpotage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StationEmpotagePolicy
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
        return $user->hasPermissionTo('stationempotageindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return mixed
     */
    public function view(User $user, StationEmpotage $stationEmpotage)
    {
        return $user->hasPermissionTo('stationempotageshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('stationempotagecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return mixed
     */
    public function update(User $user, StationEmpotage $stationEmpotage)
    {
        return $user->hasPermissionTo('stationempotageupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return mixed
     */
    public function delete(User $user, StationEmpotage $stationEmpotage)
    {
        return $user->hasPermissionTo('stationempotagedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return mixed
     */
    public function restore(User $user, StationEmpotage $stationEmpotage)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return mixed
     */
    public function forceDelete(User $user, StationEmpotage $stationEmpotage)
    {
        //
    }
}
