<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Joker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        $jokers = Joker::all();
        $availableJoker = [];

        foreach ($jokers as $joker) {
            $availableJoker[] = [
                'id' => $joker->id,
                'active' => false,
                'count' => 1
            ];
        }

        if (User::all()->count() === 0) {
            User::factory()->create();
        }

        return [
            'user_id' => User::all()->random()->id,
            'available_joker' => $availableJoker
        ];
    }
}
