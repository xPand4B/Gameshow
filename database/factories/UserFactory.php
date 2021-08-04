<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $username = '';

        do {
            $username = $this->faker->userName;
        } while(strlen($username) > 20);

        return [
            'username' => $username,
            'auth_token' => Str::random(24),
        ];
    }
}
