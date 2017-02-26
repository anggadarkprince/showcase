<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Show contact profile.
     * @return Response
     */
    public function __invoke()
    {
        return view('admin.contact.index');
    }
}
