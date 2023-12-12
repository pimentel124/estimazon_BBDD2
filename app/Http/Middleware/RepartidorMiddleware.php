<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RepartidorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role_id == 4) {
            return $next($request);
        }

        // Redirect to a specific route if not a vendor
        return redirect()->route('index')->with('error', 'Unauthorized access.');
    }
}