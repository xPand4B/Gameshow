<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('gamemaster');

            $table->unsignedSmallInteger('player_count')->default(4);
            $table->unsignedInteger('correct_points')->default(5);
            $table->boolean('points_if_wrong_answer')->default(true);
            $table->unsignedInteger('wrong_points')->default(1);
            $table->json('available_joker');
            $table->boolean('finished')->default(false);

            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
