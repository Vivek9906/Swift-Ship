<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Usage: Route::middleware('role:admin,manager')
     * Allows through if user has ANY of the listed roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Flatten comma-separated values (e.g. 'admin,manager' passed as one string)
        $allowed = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $r) {
                $allowed[] = trim($r);
            }
        }

        if (!in_array($user->role, $allowed, true)) {
            // user trying to access admin — 403
            if ($user->isuser() && in_array('admin', $allowed)) {
                abort(403, 'Access denied. This area is for SwiftShip staff only.');
            }
            // Staff trying to access user — redirect to admin dashboard
            if ($user->isStaff() && in_array('user', $allowed)) {
                return redirect()->route('admin.dashboard');
            }
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
