<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        if (User::all()->count() === 0) {
            User::factory()->create();
        }

        if (Game::all()->count() === 0) {
            Game::factory()->create();
        }

        $answers = [
            $this->getFakerAnswer(1),
            $this->getFakerAnswer(2),
            $this->getFakerAnswer(3),
            $this->getFakerAnswer(4),
        ];

        return [
            'game_id' => Game::all()->random()->id,
            'question' => $this->faker->sentence,
            'answers' => array_values($answers)
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    protected function getFakerAnswer(int $id): array
    {
        return [
            'id' => $id,
            'answer' => $this->faker->sentence,
            'isCorrect' => $this->faker->boolean,
        ];
    }
}
