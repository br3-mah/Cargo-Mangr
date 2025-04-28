<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalNetworkController extends Controller
{
    /**
     * Show global network page
     *
     * @return View
     */
    public function index(Request $request)
    {
        return view('network');
    }
}