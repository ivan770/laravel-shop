<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create addresses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the address.
     *
     * @param \App\Models\User $user
     * @param Address $address
     * @return mixed
     */
    public function update(User $user, Address $address)
    {
        return $user->id === $address->user_id;
    }

    /**
     * Determine whether the user can delete the address.
     *
     * @param \App\Models\User $user
     * @param Address $address
     * @return mixed
     */
    public function delete(User $user, Address $address)
    {
        return $user->id === $address->user_id;
    }
}
