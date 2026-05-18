<?php

namespace App\Policies\Export;

use App\Models\Export\BookingTcFinal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingTcFinalPolicy
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
        return $user->hasPermissionTo('bookingtcfinalindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return mixed
     */
    public function view(User $user, BookingTcFinal $bookingTcFinal)
    {
        return $user->hasPermissionTo('bookingtcfinalshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('bookingtcfinalcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return mixed
     */
    public function update(User $user, BookingTcFinal $bookingTcFinal)
    {
        return $user->hasPermissionTo('bookingtcfinalupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return mixed
     */
    public function delete(User $user, BookingTcFinal $bookingTcFinal)
    {
        return $user->hasPermissionTo('bookingtcfinaldelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return mixed
     */
    public function restore(User $user, BookingTcFinal $bookingTcFinal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return mixed
     */
    public function forceDelete(User $user, BookingTcFinal $bookingTcFinal)
    {
        //
    }
}
