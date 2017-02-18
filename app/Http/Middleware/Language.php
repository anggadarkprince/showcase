<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class Language
{
    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure current locale exists.
        $locale = $request->segment(1);
        /*
        if ( ! array_key_exists($locale, config('app.locales'))) {
            $segments = $request->segments();

            array_unshift($segments, config('app.fallback_locale'));

            return $this->redirector->to(implode('/', $segments));
        }

        $this->app->setLocale($locale);
        */
        if (array_key_exists($locale, config('app.locales'))) {
            $this->app->setLocale($locale);
        }

        return $next($request);
    }
}
