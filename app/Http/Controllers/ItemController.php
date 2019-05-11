<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Subcategory;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $req = Subcategory::findOrFail($id)->items;
        return ItemResource::collection($req);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $req = Item::findOrFail($id);
        return ItemResource::make($req);
    }
}
