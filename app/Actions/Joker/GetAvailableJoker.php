<?php

namespace App\Actions\Joker;

use App\Models\Joker;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAvailableJoker
{
    use AsAction;

    public function handle(): array
    {
        $jokers = Joker::all();
        $availableJoker = [];

        foreach ($jokers as $joker) {
            $availableJoker[] = [
                'id' => $joker->id,
                'active' => false,
                'count' => 1,
            ];
        }

        return $availableJoker;
    }
}
