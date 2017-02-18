<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(User $user)
    {
        return "view : show {$user->username}";
    }

    public function portfolio()
    {
        return 'view : portfolio';
    }

    public function about()
    {
        return 'view : about';
    }

    public function contact()
    {
        return 'view : contact';
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
