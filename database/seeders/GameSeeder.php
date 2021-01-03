<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gameCount = (int)$this->command->ask('How many games do you need?', 50);

        Game::factory()->count($gameCount)->create();
    }
}
