<?php

namespace App\Policies\Export;

use App\Models\Export\PositionnementTc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionnementTcPolicy
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
        return $user->hasPermissionTo('positionnementtcindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return mixed
     */
    public function view(User $user, PositionnementTc $positionnementTc)
    {
        return $user->hasPermissionTo('positionnementtcshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('positionnementtccreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return mixed
     */
    public function update(User $user, PositionnementTc $positionnementTc)
    {
        return $user->hasPermissionTo('positionnementtcupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return mixed
     */
    public function delete(User $user, PositionnementTc $positionnementTc)
    {
        return $user->hasPermissionTo('positionnementtcdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return mixed
     */
    public function restore(User $user, PositionnementTc $positionnementTc)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return mixed
     */
    public function forceDelete(User $user, PositionnementTc $positionnementTc)
    {
        //
    }
}
