<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class VueController extends Controller
{
    public function index(): View
    {
        return view('pages.vue');
    }
}
