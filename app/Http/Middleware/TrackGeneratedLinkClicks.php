<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\GeneratedLink;

class TrackGeneratedLinkClicks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('utm_source')) {
            $source = $request->input('utm_source');
            // Remove utm_source from query parameters to match target_url
            // We need to be careful. The GeneratedLink stores target_url exactly as entered.
            // If user entered "http://site.com", and visits "http://site.com?utm_source=x",
            // we want to match "http://site.com".
            // If user entered "http://site.com?a=1", and visits "http://site.com?a=1&utm_source=x",
            // we want to match "http://site.com?a=1".

            // So we take full URL and remove utm_source param.

            $url = $request->fullUrl();

            // Simple removal of utm_source parameter
            $url = preg_replace('/[?&]utm_source=[^&]+$|([?&])utm_source=[^&]+&/', '$1', $url);
            // If the regex leaves a trailing ? or &, remove it. 
            // Better way: use parse_url and http_build_query.

            $parts = parse_url($request->fullUrl());
            $query = [];
            if (isset($parts['query'])) {
                parse_str($parts['query'], $query);
            }

            if (isset($query['utm_source']) && $query['utm_source'] === $source) {
                unset($query['utm_source']);
            }

            $baseUrl = $request->url(); // Scheme + Host + Path

            $finalUrl = $baseUrl;
            if (!empty($query)) {
                $finalUrl .= '?' . http_build_query($query);
            }

            // Now find the link
            $link = GeneratedLink::where('source', $source)
                ->where('target_url', $finalUrl)
                ->first();

            if ($link) {
                $link->increment('click_count');

                // Record detailed click
                \App\Models\GeneratedLinkClick::create([
                    'generated_link_id' => $link->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'location' => null, // Placeholder for GeoIP if needed
                ]);

                // Store in session for attribution
                session()->put('generated_link_id', $link->id);
                \Illuminate\Support\Facades\Log::info('Link tracked in middleware: ' . $link->id . ' Session ID: ' . session()->getId());
            }
        }

        return $next($request);
    }
}
