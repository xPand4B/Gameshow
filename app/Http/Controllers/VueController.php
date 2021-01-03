<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class VueController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.vue');
    }
}
