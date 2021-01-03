<?php

namespace Tests\Http\Resources\Joker;

use App\Http\Resources\Joker\JokerCollection;
use App\Http\Resources\Joker\JokerResource;
use App\Models\Joker;
use Illuminate\Http\Request;

trait JokerResourceTrait
{
    /**
     * @return array
     */
    public function getJokerResource(): array
    {
        $request = new Request();
        $joker = Joker::first();

        return (new JokerResource($joker))->toArray($request);
    }

    /**
     * @return array
     */
    public function getJokerCollection(): array
    {
        $request = new Request();
        $joker = Joker::all();

        return (new JokerCollection($joker))->toArray($request);
    }
}
