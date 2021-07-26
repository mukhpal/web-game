<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainGameStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_game_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('team_id');
            $table->integer('event_id');
            $table->string('game_key')->comment('main game key');
            $table->integer('start_time')->comment('when game has started')->default(0);
            $table->integer('end_time')->comment('when game will ends')->default(0);
            $table->integer('status')->comment('1 -> Active game, 2 -> game finished')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_game_status');
    }
}
