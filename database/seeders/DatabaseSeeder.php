<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GameSeeder::class,
        ]);

        $this->command->info("\nTotal:");
        $this->command->info("=============");
        $this->command->info("Users     : " . User::all()->count());
        $this->command->info("Games     : " . Game::all()->count());
        $this->command->info("Questions : " . Question::all()->count());
    }
}
