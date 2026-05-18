<?php

namespace App\Policies\Engins;

use App\Models\Engins\ApproCarburant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApproCarburantPolicy
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
        return $user->hasPermissionTo('approcarburantindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return mixed
     */
    public function view(User $user, ApproCarburant $approCarburant)
    {
        return $user->hasPermissionTo('approcarburantshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('approcarburantcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return mixed
     */
    public function update(User $user, ApproCarburant $approCarburant)
    {
        return $user->hasPermissionTo('approcarburantupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return mixed
     */
    public function delete(User $user, ApproCarburant $approCarburant)
    {
        return $user->hasPermissionTo('approcarburantdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ApproCarburant $approCarburant)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ApproCarburant $approCarburant)
    {
        //
    }
}
