<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreItemRequest;
use App\Http\Resources\CartLineResource;
use App\Http\Resources\CartResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CartController extends Controller
{
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
     * @param User $user
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Authenticatable $user, $id)
    {
        try {
            $cart = $user->carts()->findOrFail($id)->items;
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 404);
        }
        return CartLineResource::collection($cart);
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
        try {
            $cart = $user->carts()->active()->findOrFail($request->input('cart_id'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 404);
        }
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
    public function destroy(Authenticatable $user, $cart_id, $id)
    {
        try {
            $cart = $user->carts()->active()->findOrFail($cart_id);
            $cart->items()->findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 404);
        }
        return response()->json(['success' => true, 'data' => []]);
    }
}
