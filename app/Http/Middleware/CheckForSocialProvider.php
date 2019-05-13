<?php

namespace App\Http\Middleware;

use Closure;

class CheckForSocialProvider
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array($request->route('provider'), config("services.providers"))) {
            return response()->json(["success" => false, "data" => "Unsupported provider"], 400);
        }

        return $next($request);
    }
}
