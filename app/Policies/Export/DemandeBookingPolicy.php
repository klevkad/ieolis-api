<?php

namespace App\Policies\Export;

use App\Models\Export\DemandeBooking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemandeBookingPolicy
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
        return $user->hasPermissionTo('demandebookingindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return mixed
     */
    public function view(User $user, DemandeBooking $demandeBooking)
    {
        return $user->hasPermissionTo('demandebookingshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('demandebookingcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return mixed
     */
    public function update(User $user, DemandeBooking $demandeBooking)
    {
        return $user->hasPermissionTo('demandebookingupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return mixed
     */
    public function delete(User $user, DemandeBooking $demandeBooking)
    {
        return $user->hasPermissionTo('demandebookingdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return mixed
     */
    public function restore(User $user, DemandeBooking $demandeBooking)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return mixed
     */
    public function forceDelete(User $user, DemandeBooking $demandeBooking)
    {
        //
    }
}
