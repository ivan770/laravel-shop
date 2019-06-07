<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreItemRequest;
use App\Http\Resources\CartLineResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CartController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Cart::class);
    }

    protected function resourceAbilityMap()
    {
        return [
            'show' => 'view'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Authenticatable $user)
    {
        $carts = $user->carts()->get();
        return CartResource::collection($carts);
    }

    /**
     * @param Cart $cart
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Cart $cart)
    {
        return CartLineResource::collection($cart->items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @param \Illuminate\Http\Request $request
     * @return CartLineResource
     */
    public function store(Authenticatable $user, StoreItemRequest $request)
    {
        $cart = $user->carts()->firstOrCreate(["delivery_status" => 0]);
        $item = $cart->items()->create(['item_id' => $request->input('item_id'), 'count' => $request->input('count', 1)]);
        return CartLineResource::make($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authenticatable $user, $id)
    {
        $cart = $user->carts()->firstOrCreate(["delivery_status" => 0]);
        $cart->items()->findOrFail($id)->delete();
        return response()->json(['success' => true, 'data' => []]);
    }
}
