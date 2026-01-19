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

            if (!$link) {
                // Try alternate URL (toggle trailing slash)
                $altUrl = str_ends_with($finalUrl, '/')
                    ? substr($finalUrl, 0, -1)
                    : $finalUrl . '/';

                \Illuminate\Support\Facades\Log::info("TrackGeneratedLinkClicks: Exact match failed, trying alternate URL: {$altUrl}");

                $link = GeneratedLink::where('source', $source)
                    ->where('target_url', $altUrl)
                    ->first();
            }

            if (!$link) {
                // Debugging: Log what we DO have for this source to help user diagnose (e.g. http vs https)
                $candidates = GeneratedLink::where('source', $source)->get();
                if ($candidates->isNotEmpty()) {
                    \Illuminate\Support\Facades\Log::warning("TrackGeneratedLinkClicks: Mismatch! found candidates for source '{$source}': " . $candidates->pluck('target_url')->implode(', '));

                    // Fallback: Try to match without scheme to handle http/https proxy issues
                    // This is risky if you have same URL on http and https as different links, but unlikely for this app.
                    foreach ($candidates as $candidate) {
                        $cUrl = $candidate->target_url;
                        // normalize both to remove scheme and trailing slash for comparison
                        $cNorm = preg_replace('#^https?://#', '', rtrim($cUrl, '/'));
                        $fNorm = preg_replace('#^https?://#', '', rtrim($finalUrl, '/'));

                        if ($cNorm === $fNorm) {
                            $link = $candidate;
                            \Illuminate\Support\Facades\Log::info("TrackGeneratedLinkClicks: Fuzzy matched link ID: {$link->id} (Scheme/Protocol mismatch ignored)");
                            break;
                        }
                    }
                }
            }

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

                    // Attempt to resolve location
                    $location = null;
                    try {
                        // 1. Try Cloudflare header
                        $location = $request->header('CF-IPCountry');

                        // 2. If no header and not local, try external API
                        if (!$location && app()->environment('production')) {
                            $ip = $request->ip();
                            // Simple check to skip local IPs if not caught by env check
                            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                                $response = \Illuminate\Support\Facades\Http::timeout(2)->get("http://ip-api.com/json/{$ip}?fields=country");
                                if ($response->successful()) {
                                    $data = $response->json();
                                    $location = $data['country'] ?? null;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        // Fail silently on location to not break the click tracking
                        \Illuminate\Support\Facades\Log::warning("TrackGeneratedLinkClicks: Location lookup failed: " . $e->getMessage());
                    }

                    // Record detailed click
                    \App\Models\GeneratedLinkClick::create([
                        'generated_link_id' => $link->id,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'location' => $location,
                    ]);

                    \Illuminate\Support\Facades\Log::info("TrackGeneratedLinkClicks: Click detail recorded. Location: " . ($location ?? 'Unknown'));

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
