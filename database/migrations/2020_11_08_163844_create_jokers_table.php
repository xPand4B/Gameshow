<?php

use App\Models\Joker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jokers', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->timestampsTz();
        });

        $jokers = [
            'telephone',
            '5050',
            'chat',
            'googleImages'
        ];

        foreach ($jokers as $joker) {
            Joker::create([
                'name' => $joker,
                'description' => null,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jokers');
    }
};
