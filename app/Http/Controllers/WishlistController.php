<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Authenticatable $user)
    {
        return ItemResource::collection($user->wishlist);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Authenticatable $user, StoreItemRequest $request)
    {
        return response()->json($user->wishlist()->syncWithoutDetaching($request->input('item_id')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authenticatable $user, $id)
    {
        return response()->json($user->wishlist()->detach($id));
    }
}
