<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
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
    public function index(Repository $cache, Category $category)
    {
        $result = $cache->remember("{$category->id}_items", Carbon::now()->addHour(), function () use ($category) {
            return $category->items;
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

    public function search(Repository $cache, Request $request)
    {
        $query = $request->input('query');
        $result = $cache->remember("{$query}_search", Carbon::now()->addHour(), function () use ($query) {
            return Item::search($query)->take(50)->get();
        });
        return ItemResource::collection($result);
    }
}
