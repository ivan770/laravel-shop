<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

class APIController extends Controller
{
    public function getSelf()
    {
        return response()->json(auth()->user());
    }
}