<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\CreateEditAddressRequest;
use App\Http\Resources\AddressResource;
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
     * @param CreateEditAddressRequest $request
     * @param int $id
     * @return AddressResource
     */
    public function update(CreateEditAddressRequest $request, $id)
    {
        try {
            $result = auth()->user()->addresses()->find($id);
            if ($result == null) {
                throw new ModelNotFoundException("Saved address with provided ID doesn't exist");
            }
            $result->update($request->validated());
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 400);
        }
        return response()->json(['success' => true, 'data' => []]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = auth()->user()->addresses()->find($id);
            if ($result == null) {
                throw new ModelNotFoundException("Saved address with provided ID doesn't exist");
            }
            $result->delete();
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 400);
        }
        return response()->json(['success' => true, 'data' => []]);
    }
}
