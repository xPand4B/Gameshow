<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $userCount = (int) $this->command->ask('How many users do you need?', 20);

        User::factory()->count($userCount)->create();
    }
}
