<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ControladorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role_id == 3) {
            return $next($request);
        }

        return redirect()->route('index')->with('error', 'Unauthorized access.');
    }
}
