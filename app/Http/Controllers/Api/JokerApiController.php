<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Joker\JokerCollection;
use App\Http\Resources\Joker\JokerResource;
use App\Models\Joker;
use Illuminate\Http\Request;

class JokerApiController extends Controller
{
    /**
     * @param Request $request
     * @return JokerCollection
     */
    public function index(Request $request): JokerCollection
    {
        $games = Joker::paginate(15);

        return new JokerCollection($games);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JokerResource
     */
    public function show(Request $request, $id): JokerResource
    {
        $joker = Joker::findOrFail($id);

        return new JokerResource($joker);
    }
}
