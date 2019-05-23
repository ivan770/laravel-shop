<?php

namespace App\Contracts;

interface PaymentProcessor
{
    public function processPayment($user, $draft, $address, $cart);

    public function build($user, $draft, $address, $cart);

    public function charge();

    public function transferCart();
}