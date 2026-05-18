<?php

namespace App\Policies\Export;

use App\Models\Export\BookingTc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingTcPolicy
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
        return $user->hasPermissionTo('bookingtcindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return mixed
     */
    public function view(User $user, BookingTc $bookingTc)
    {
        return $user->hasPermissionTo('bookingtcshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('bookingtccreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return mixed
     */
    public function update(User $user, BookingTc $bookingTc)
    {
        return $user->hasPermissionTo('bookingtcupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return mixed
     */
    public function delete(User $user, BookingTc $bookingTc)
    {
        return $user->hasPermissionTo('bookingtcdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return mixed
     */
    public function restore(User $user, BookingTc $bookingTc)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return mixed
     */
    public function forceDelete(User $user, BookingTc $bookingTc)
    {
        //
    }
}
