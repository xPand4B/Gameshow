<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            GameSeeder::class,
        ]);

        $userCount     = User::all()->count();
        $gameCount     = Game::all()->count();
        $questionCount = Question::all()->count();

        $this->command->info("\nTotal:");
        $this->command->info("=============");
        $this->command->info("Users     : {$userCount}");
        $this->command->info("Games     : {$gameCount}");
        $this->command->info("Questions : {$questionCount}");
    }
}
