<?php

namespace App\Contracts;

interface ChargeBuilder
{
    public function constructOrder($cart);

    public function build($cart);

    public function calculatePrices();

    public function calculateTotal();

    public function checkForEmptyCart();

    public function toResult();
}