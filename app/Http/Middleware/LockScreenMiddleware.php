<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LockScreenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user triggers the lock route, let them proceed (to lock the session)
        if ($request->routeIs('admin.lock-screen') || $request->routeIs('admin.lock')) {
            return $next($request);
        }

        // If session is locked, redirect to lock screen
        if (session('locked')) {
            // Allow logout to work even if locked
            if ($request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('admin.lock-screen');
        }

        return $next($request);
    }
}
