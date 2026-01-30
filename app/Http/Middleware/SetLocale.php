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
        // 1. Check for 'lang' query parameter (SEO / Direct Link support)
        if ($request->has('lang')) {
            $lang = $request->query('lang');
            $available = config('app.available_locales', ['en']); // Fallback to 'en' if config missing

            if (in_array($lang, $available)) {
                session(['locale' => $lang]);
                App::setLocale($lang);
                // If we want to persist this change for subsequent requests without param, session does that.
            }
        }

        // 2. Default logic
        $locale = session('locale');

        // FORCE Russian for Admin Panel, ignoring session
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
