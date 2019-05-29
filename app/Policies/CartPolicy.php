<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the cart.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cart  $cart
     * @return mixed
     */
    public function view(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }
}
