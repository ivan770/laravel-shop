<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\User;
use App\Contracts\PaymentProcessor as PaymentProcessorContract;
use App\Notifications\Checkout;

class PaymentProcessor implements PaymentProcessorContract
{
    /**
     * @var User $user
     */
    protected $user;

    protected $draft;

    /**
     * @var Address $address
     */
    protected $address;

    /**
     * @var Cart $cart
     */
    protected $cart;

    protected $stripeCharge;

    public function processPayment($user, $draft, $address, $cart)
    {
        return $this
            ->build($user, $draft, $address, $cart)
            ->charge()
            ->transferCart()
            ->notifyUser();
    }

    public function build($user, $draft, $address, $cart)
    {
        $this->user = $user;
        $this->draft = $draft;
        $this->address = $address;
        $this->cart = $cart;
        return $this;
    }

    public function charge()
    {
        $total = $this->draft["total"] * 100;
        $this->stripeCharge = $this->user->charge($total, [
            "description" => "Payment #{$this->cart->id}"
        ]);
        return $this;
    }

    public function transferCart()
    {
        $this->cart->update(["delivery_status" => 1, "address" => $this->address->toJson()]);
        $this->user->carts()->create();
        return $this;
    }

    public function notifyUser()
    {
        $this->user->notify(new Checkout($this->stripeCharge));
    }
}