<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Default to session locale if exists
        $locale = session('locale');

        // FORCE Russian for Admin Panel, ignoring session
        // Only allow session override if we actually want admin-switchable languages later.
        // Given the requirement "must be Russian", we prioritize the admin context.
        if (
            $request->is('admin*') ||
            ($request->route() && in_array('role:admin', $request->route()->gatherMiddleware() ?? []))
        ) {
            $locale = 'ru';
        } elseif (!$locale) {
            // For frontend, if no session, default to English
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
