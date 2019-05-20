<?php

namespace App\Exceptions\Payment;

use Exception;

class EmptyCartCharge extends Exception
{
    public function render($request)
    {
        return response()->json(['success' => false, 'data' => ["Unable to charge empty cart"]], 400);
    }
}
