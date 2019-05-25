<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreItemRequest;
use App\Http\Resources\ItemResource;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ItemResource::collection(auth()->user()->wishlist);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        return response()->json(auth()->user()->wishlist()->syncWithoutDetaching($request->input('item_id')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(auth()->user()->wishlist()->detach($id));
    }
}
