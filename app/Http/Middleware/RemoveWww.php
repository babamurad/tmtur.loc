<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class RemoveWww
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Str::startsWith($request->getHost(), 'www.')) {
            $host = Str::replaceFirst('www.', '', $request->getHost());
            $url = $request->getScheme() . '://' . $host . $request->getPathInfo();

            if ($request->getQueryString()) {
                $url .= '?' . $request->getQueryString();
            }

            return redirect()->to($url, 301);
        }

        return $next($request);
    }
}
