<?php

namespace App\Http\Controllers\Payment;

use App\Contracts\ChargeBuilder;
use App\Contracts\PaymentProcessor;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChargeController extends Controller
{
    /**
     * @param \App\Models\User $user
     * @param \App\Services\ChargeBuilder $builder
     * @param \App\Services\PaymentProcessor $paymentProcessor
     * @param $addrid
     * @return \Illuminate\Http\JsonResponse
     */
    public function charge(Authenticatable $user, ChargeBuilder $builder, PaymentProcessor $paymentProcessor, $addrid)
    {
        try {
            $cart = $user->carts()->active()->firstOrFail();
            $address = $user->addresses()->findOrFail($addrid);
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
