<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameIceBreakerScreenTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_ice_breaker_screen_time', function (Blueprint $table) {
            $table->primary(['ibst_event_id', 'ibst_team_id']);
            $table->bigInteger('ibst_event_id')->unsigned();
            $table->bigInteger('ibst_team_id')->unsigned();
            $table->string('ibst_event_start_time')->nullable();
            $table->string('ibst_awaiting_screen_time')->nullable();
            $table->string('ibst_fun_facts_screen_time')->nullable();
            $table->string('ibst_ice_breaker_game_screen_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_ice_breaker_screen_time');
    }
}
