<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Contact extends Controller
{
    /**
     * Show contact profile.
     * @return Response
     */
    public function __invoke()
    {
        return view('contact.index');
    }
}
