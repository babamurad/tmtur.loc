<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceWww
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Редирект сработает ТОЛЬКО если сайт запущен в режиме production (на сервере)
        if (app()->environment('production')) {
            if (!str_contains($request->header('host'), 'www.')) {
                return redirect()->to(
                    'https://www.' . $request->getHttpHost() . $request->getRequestUri(),
                    301
                );
            }
        }

        return $next($request);
    }
}
