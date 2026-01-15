<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Handle single string with pipes or commas if passed as one argument
        if (count($roles) === 1 && (str_contains($roles[0], '|') || str_contains($roles[0], ','))) {
            $roles = preg_split('/[|,]/', $roles[0]);
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'У вас нет прав доступа к этой странице');
        }

        return $next($request);
    }
}
