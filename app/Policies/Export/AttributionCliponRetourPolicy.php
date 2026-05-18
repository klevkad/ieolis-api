<?php

namespace App\Policies\Export;

use App\Models\Export\AttributionCliponRetour;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributionCliponRetourPolicy
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
        return $user->hasPermissionTo('attributioncliponretourindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return mixed
     */
    public function view(User $user, AttributionCliponRetour $attributionCliponRetour)
    {
        return $user->hasPermissionTo('attributioncliponretourshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('attributioncliponretourcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return mixed
     */
    public function update(User $user, AttributionCliponRetour $attributionCliponRetour)
    {
        return $user->hasPermissionTo('attributioncliponretourupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return mixed
     */
    public function delete(User $user, AttributionCliponRetour $attributionCliponRetour)
    {
        return $user->hasPermissionTo('attributioncliponretourdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return mixed
     */
    public function restore(User $user, AttributionCliponRetour $attributionCliponRetour)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return mixed
     */
    public function forceDelete(User $user, AttributionCliponRetour $attributionCliponRetour)
    {
        //
    }
}
