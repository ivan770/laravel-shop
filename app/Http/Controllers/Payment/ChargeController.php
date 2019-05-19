<?php

namespace App\Http\Controllers\Payment;

use App\Models\Address;
use App\Services\ChargeBuilder;
use App\Services\PaymentProcessor;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChargeController extends Controller
{
    public function charge(Authenticatable $user, ChargeBuilder $builder, PaymentProcessor $paymentProcessor, Address $address)
    {
        try {
            $cart = $user->carts()->active()->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 404);
        }
        $draft = $builder
            ->build($cart)
            ->calculatePrices()
            ->calculateTotal()
            ->toResult();
        try {
            $paymentProcessor
                ->build($user, $draft, $address, $cart)
                ->charge()
                ->transferCart();
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 400);
        }
        return response()->json(['success' => true, 'data' => []]);
    }
}
