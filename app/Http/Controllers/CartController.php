<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreItemRequest;
use App\Http\Resources\CartLineResource;
use App\Http\Resources\CartResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CartResource::collection(auth()->user()->carts);
    }

    public function show($id)
    {
        try {
            $cart = auth()->user()->carts()->findOrFail($id)->items;
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 400);
        }
        return CartLineResource::collection($cart);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        try {
            $cart = auth()->user()->carts()->active()->findOrFail($request->input('cart_id'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 400);
        }
        $item = $cart->items()->create(['item_id' => $request->input('item_id')]);
        return CartLineResource::make($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cart_id, $id)
    {
        try {
            $cart = auth()->user()->carts()->active()->findOrFail($cart_id);
            $cart->items()->findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 400);
        }
        return response()->json(['success' => true, 'data' => []]);
    }
}
