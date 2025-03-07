<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    /**
     * Show home page
     *
     * @return View
     */
    public function index(Request $request)
    {
        return view('contact-us');
    }
}