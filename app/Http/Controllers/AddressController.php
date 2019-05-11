<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\CreateEditAddressRequest;
use App\Http\Resources\AddressResource;

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
        return new AddressResource(auth()->user()->addresses()->create($request->validated()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateEditAddressRequest $request
     * @param int $id
     * @return AddressResource
     */
    public function update(CreateEditAddressRequest $request, $id)
    {
        return response()->json(auth()->user()->addresses()->findOrFail($id)->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(auth()->user()->addresses()->findOrFail($id)->delete());
    }
}
