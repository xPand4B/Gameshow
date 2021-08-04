<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('game_id')
                ->constrained('games')
                ->cascadeOnDelete();

            $table->string('question');
            $table->json('answers');

            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
}
