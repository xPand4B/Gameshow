<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $gameCount = (int) $this->command->ask('How many games do you need?', 50);

        Game::factory()->count($gameCount)->create();
    }
}
