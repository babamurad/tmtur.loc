<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWww
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->isProduction()) {
            $host = $request->getHost();

            if (!str_starts_with($host, 'www.')) {
                return redirect()->away($request->getScheme() . '://www.' . $host . $request->getRequestUri(), 301);
            }
        }

        return $next($request);
    }
}
