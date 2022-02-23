<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    protected array $productionSeeder = [];

    protected array $devSeeder = [
        UserSeeder::class,
        GameSeeder::class,
    ];

    protected array $testingSeeder = [];

    public function run(): void
    {
        $seederTyp = $this->productionSeeder;

        if (App::environment(['dev', 'development', 'local'])) {
            $seederTyp = $this->devSeeder;
        } elseif (App::environment(['testing'])) {
            $seederTyp = $this->testingSeeder;
        }

        $this->call($seederTyp);

        $this->command->info("\nTotal:");
        $this->command->info('=============');
        $this->command->info('Users     : ' . User::all()->count());
        $this->command->info('Games     : ' . Game::all()->count());
        $this->command->info('Questions : ' . Question::all()->count());
    }
}
