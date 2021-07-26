<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('game_time')->default('60')->comment('Time of game played by event join members (In minutes)');
            $table->integer('awaiting_screen_time')->default('5')->comment('Awaiting screen time where the motivational quotes are seen (In minutes) ');
            $table->integer('team_size')->default('5')->comment('add limit how many members in each team');
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
        Schema::dropIfExists('game_settings');
    }
}
