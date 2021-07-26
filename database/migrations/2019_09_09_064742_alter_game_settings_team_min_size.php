<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGameSettingsTeamMinSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('min_team_size')->default('3')->after('team_size')->comment('Min no of members in a team');
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
            $table->dropColumn('min_team_size');
        });
    }
}
