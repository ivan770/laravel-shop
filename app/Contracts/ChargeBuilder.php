<?php

namespace App\Contracts;

interface ChargeBuilder
{
    public function build($cart);

    public function calculatePrices();

    public function calculateTotal();

    public function checkForEmptyCart();

    public function toResult();
}