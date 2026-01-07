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

            \Illuminate\Support\Facades\Log::info("TrackGeneratedLinkClicks: Processing request with utm_source={$source}");

            // Data cleanup logic
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

            \Illuminate\Support\Facades\Log::info("TrackGeneratedLinkClicks: Search params", [
                'source' => $source,
                'target_url' => $finalUrl
            ]);

            // Now find the link
            $link = GeneratedLink::where('source', $source)
                ->where('target_url', $finalUrl)
                ->first();

            if ($link) {
                \Illuminate\Support\Facades\Log::info("TrackGeneratedLinkClicks: Link found ID: {$link->id}, Current Click Count: " . ($link->click_count ?? 'NULL'));

                try {
                    // Robust increment: handle NULL case explicitly
                    if (is_null($link->click_count)) {
                        $link->click_count = 0;
                        $link->save();
                    }

                    $link->increment('click_count');

                    // Verify increment
                    $link->refresh();
                    \Illuminate\Support\Facades\Log::info("TrackGeneratedLinkClicks: New Click Count: {$link->click_count}");

                    // Record detailed click
                    \App\Models\GeneratedLinkClick::create([
                        'generated_link_id' => $link->id,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'location' => null, // Placeholder for GeoIP if needed
                    ]);

                    \Illuminate\Support\Facades\Log::info("TrackGeneratedLinkClicks: Click detail recorded");

                    // Store in session for attribution
                    session()->put('generated_link_id', $link->id);
                    session()->save(); // Forcing save just in case

                    \Illuminate\Support\Facades\Log::info('Link tracked in middleware: ' . $link->id . ' Session ID: ' . session()->getId());

                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('TrackGeneratedLinkClicks: Error processing click: ' . $e->getMessage());
                }
            } else {
                \Illuminate\Support\Facades\Log::warning("TrackGeneratedLinkClicks: No matching link found for source: {$source} and url: {$finalUrl}");
            }
        }

        return $next($request);
    }
}
