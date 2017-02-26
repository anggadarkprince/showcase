<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UrlAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $segment = 1;
        if (array_key_exists($request->segment($segment), config('app.locales'))) {
            $segment = 2;
        }
        if ($request->segment($segment) !== Auth::user()->username) {
            abort(403, "Unauthorized to perform this action");
        }
        return $next($request);
    }
}
