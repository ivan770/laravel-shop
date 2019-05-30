<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Repository $cache, Subcategory $subcategory)
    {
        $result = $cache->remember("{$subcategory->id}_items", Carbon::now()->addHour(), function () use ($subcategory) {
            return $subcategory->items;
        });
        return ItemResource::collection($result);
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
