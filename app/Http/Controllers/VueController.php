<?php

namespace App\Http\Controllers;

use App\Events\Game\LobbyJoinedEvent;
use App\Models\Game;

class VueController extends Controller
{
    public function index()
    {
        return view('pages.vue');
    }
}
