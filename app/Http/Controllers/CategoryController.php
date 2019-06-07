<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Cache\Repository;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Repository $cache)
    {
        $categories = $cache->remember("categories", now()->addHour(), function () {
            return Category::all();
        });
        return CategoryResource::collection($categories);
    }
}
