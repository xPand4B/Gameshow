<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Joker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
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

        return [
            'user_id' => User::all()->random()->id,
            'available_joker' => $availableJoker
        ];
    }
}
