<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id)
    {
        try {
            $result = Subcategory::find($id);
            if ($result == null) {
                throw new ModelNotFoundException("Subcategory with that ID doesn't exist");
            }
            $result = $result->items;
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 400);
        }
        return ItemResource::collection($result);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ItemResource
     */
    public function show($id)
    {
        try {
            $result = Item::find($id);
            if ($result == null) {
                throw new ModelNotFoundException("Item with that ID doesn't exist");
            }
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'data' => [$e->getMessage()]], 400);
        }
        return ItemResource::make($result);
    }
}
