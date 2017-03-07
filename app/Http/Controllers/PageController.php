<?php

namespace App\Http\Controllers;

use App\Portfolio;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function explore(Request $request)
    {
        $portfolios = new Portfolio();
        $portfolios = $portfolios->explore();
        $title = 'Discover Masterpiece';
        $explore_active = true;

        $page = $request->get('page', 1);

        // Check cache first
        $pageCached = Cache::tags('discover')->get('explore_page_' . $page);

        if ($pageCached != null) {
            return $pageCached;
        }

        $renderedView = view('portfolio.discover',
            compact('portfolios', 'title', 'explore_active'))->render();

        Cache::tags('discover')->put('explore_page_' . $page, $renderedView, 60);

        return $renderedView;
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
