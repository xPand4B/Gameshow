<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('player_count')->default(4);
            $table->unsignedInteger('correct_points')->default(5);
            $table->boolean('points_if_wrong_answer')->default(true);
            $table->unsignedInteger('wrong_points')->default(1);
            $table->json('available_joker');
            $table->boolean('finished')->default(false);
            $table->boolean('started')->default(false);

            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
}
