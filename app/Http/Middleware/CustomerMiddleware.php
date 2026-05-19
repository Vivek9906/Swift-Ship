<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to continue.');
        }
        if (!in_array(auth()->user()->role, ['customer', 'user'], true)) {
            abort(403, 'This area is for customers only.');
        }
        return $next($request);
    }
}
