<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisableInProduction
{
    /**
     * Handle an incoming request. Everything that has this middleware can't be
     * accessed in the production mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('app.env') == 'production') {
            return response()->json([
                'message' => "Not Found"
            ], 404);
        }

        return $next($request);
    }
}
