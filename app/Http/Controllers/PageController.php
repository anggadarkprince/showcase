<?php

namespace App\Http\Controllers;

use App\Portfolio;
use App\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function explore()
    {
        $portfolios = new Portfolio();
        $portfolios = $portfolios->explore();
        $title = 'Discover Masterpiece';
        $explore_active = true;
        return view('portfolio.discover', compact('portfolios', 'title', 'explore_active'));
    }

    public function help()
    {
        return view('welcome');
    }

    /**
     * Change locale when is not using prefix like local.dev/en/dashboard
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLocale(Request $request)
    {
        $locale = $request->get('lang', 'en');
        $redirect = $request->get('redirect', url('/'));

        if (!array_key_exists($locale, config('app.locales'))) {
            $locale = config('app.fallback_locale');
        }

        $this->app->setLocale($locale);

        return redirect($redirect);
    }
}
