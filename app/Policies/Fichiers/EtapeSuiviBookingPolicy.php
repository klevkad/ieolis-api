<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\EtapeSuiviBooking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EtapeSuiviBookingPolicy
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
        return $user->hasPermissionTo('etapesuivibookingindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return mixed
     */
    public function view(User $user, EtapeSuiviBooking $etapeSuiviBooking)
    {
        return $user->hasPermissionTo('etapesuivibookingshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('etapesuivibookingcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return mixed
     */
    public function update(User $user, EtapeSuiviBooking $etapeSuiviBooking)
    {
        return $user->hasPermissionTo('etapesuivibookingupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return mixed
     */
    public function delete(User $user, EtapeSuiviBooking $etapeSuiviBooking)
    {
        return $user->hasPermissionTo('etapesuivibookingdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return mixed
     */
    public function restore(User $user, EtapeSuiviBooking $etapeSuiviBooking)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return mixed
     */
    public function forceDelete(User $user, EtapeSuiviBooking $etapeSuiviBooking)
    {
        //
    }
}
