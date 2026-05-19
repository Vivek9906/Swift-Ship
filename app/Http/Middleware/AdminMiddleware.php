<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please log in to access admin panel.');
        }
        if (!in_array(auth()->user()->role, ['admin', 'staff', 'manager', 'viewer'], true)) {
            abort(403, 'Access denied. Admin privileges required.');
        }
        return $next($request);
    }
}
