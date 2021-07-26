<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGameSettingsTeamCash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('team_cash')->default('1080')->after('answer_screen_time')->comment('Initial cash for each team on market madness');
            $table->integer('round_team_cash')->default('240')->after('team_cash')->comment('Further cash distribution on each round completions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->dropColumn('team_cash');
            $table->dropColumn('round_team_cash');
        });
    }
}
