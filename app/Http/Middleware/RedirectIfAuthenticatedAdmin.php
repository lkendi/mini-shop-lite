<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
