<?php

namespace App\Policies\Export;

use App\Models\Export\MotifRefusBooking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MotifRefusBookingPolicy
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
        return $user->hasPermissionTo('motifrefusbookingindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return mixed
     */
    public function view(User $user, MotifRefusBooking $motifRefusBooking)
    {
        return $user->hasPermissionTo('motifrefusbookingshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('motifrefusbookingcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return mixed
     */
    public function update(User $user, MotifRefusBooking $motifRefusBooking)
    {
        return $user->hasPermissionTo('motifrefusbookingupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return mixed
     */
    public function delete(User $user, MotifRefusBooking $motifRefusBooking)
    {
        return $user->hasPermissionTo('motifrefusbookingdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return mixed
     */
    public function restore(User $user, MotifRefusBooking $motifRefusBooking)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return mixed
     */
    public function forceDelete(User $user, MotifRefusBooking $motifRefusBooking)
    {
        //
    }
}
