<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Subcategory $subcategory)
    {
        return ItemResource::collection($subcategory->items);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ItemResource
     */
    public function show(Item $item)
    {
        return ItemResource::make($item);
    }

    public function search(Request $request)
    {
        $search = Item::search($request->input('query'))->take(50)->get();
        return ItemResource::collection($search);
    }
}
