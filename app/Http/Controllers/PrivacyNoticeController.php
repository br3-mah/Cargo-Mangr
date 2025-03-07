<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyNoticeController extends Controller
{
    /**
     * Show home page
     *
     * @return View
     */
    public function index(Request $request)
    {
        return view('privacy-notice');
    }
}