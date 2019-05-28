<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Laravel\Socialite\Contracts\Factory;

class APIController extends Controller
{
    public function getSelf()
    {
        return response()->json(auth()->user());
    }

    public function redirect(Factory $socialite, $provider)
    {
        return $socialite->driver($provider)->stateless()->redirect();
    }

    public function callback(Factory $socialite, $provider)
    {
        $user = $socialite->driver($provider)->stateless()->user();
        auth()->user()->update(["{$provider}_id" => $user->getId()]);
        return redirect()->route('home');
    }
}