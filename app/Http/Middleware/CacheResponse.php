<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $ttl = 3600): Response
    {
        // Only cache GET requests for non-authenticated users
        if (!$request->isMethod('GET') || $request->user() || config('app.debug')) {
            return $next($request);
        }

        $key = 'page_cache_' . \Illuminate\Support\Str::slug($request->fullUrl());

        if (\Illuminate\Support\Facades\Cache::has($key)) {
            $content = \Illuminate\Support\Facades\Cache::get($key);
            return response($content)->header('X-Page-Cache', 'HIT');
        }

        $response = $next($request);

        if ($response->isSuccessful()) {
            // Cache the content
            \Illuminate\Support\Facades\Cache::put($key, $response->getContent(), $ttl);

            // Also set browser cache headers
            $response->headers->set('Cache-Control', 'public, max-age=' . $ttl);
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + $ttl) . ' GMT');
            $response->headers->set('X-Page-Cache', 'MISS');
        }

        return $response;
    }
}
