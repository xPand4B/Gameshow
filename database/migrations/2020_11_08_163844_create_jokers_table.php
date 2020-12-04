<?php

use App\Models\Joker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJokersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jokers');
    }
}
