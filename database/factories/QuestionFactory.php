<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
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
            'context' => $this->faker->sentence,
            'isCorrect' => $this->faker->boolean,
        ];
    }
}
