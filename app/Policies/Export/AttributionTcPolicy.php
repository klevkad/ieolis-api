<?php

namespace App\Policies\Export;

use App\Models\Export\AttributionTc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributionTcPolicy
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
        return $user->hasPermissionTo('attributiontcindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return mixed
     */
    public function view(User $user, AttributionTc $attributionTc)
    {
        return $user->hasPermissionTo('attributiontcshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('attributiontccreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return mixed
     */
    public function update(User $user, AttributionTc $attributionTc)
    {
        return $user->hasPermissionTo('attributiontcupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return mixed
     */
    public function delete(User $user, AttributionTc $attributionTc)
    {
        return $user->hasPermissionTo('attributiontcdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return mixed
     */
    public function restore(User $user, AttributionTc $attributionTc)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return mixed
     */
    public function forceDelete(User $user, AttributionTc $attributionTc)
    {
        //
    }
}
