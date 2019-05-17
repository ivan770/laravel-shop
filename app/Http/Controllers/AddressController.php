<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\CreateEditAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return AddressResource::collection(auth()->user()->addresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateEditAddressRequest $request
     * @return AddressResource
     */
    public function store(CreateEditAddressRequest $request)
    {
        return AddressResource::make(auth()->user()->addresses()->create($request->validated()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param CreateEditAddressRequest $request
     * @param int $id
     * @return AddressResource
     */
    public function update(Authenticatable $user, CreateEditAddressRequest $request, $id)
    {
        try {
            $address = $user->addresses()->findOrFail($id);
            $result = tap($address)->update($request->validated());
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 404);
        }
        return AddressResource::make($result);
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
        try {
            $result = $user->addresses()->findOrFail($id);
            $result->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 404);
        }
        return response()->json(['success' => true, 'data' => []]);
    }
}
