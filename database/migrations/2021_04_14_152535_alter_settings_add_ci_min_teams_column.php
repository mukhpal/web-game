<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSettingsAddCiMinTeamsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('min_teams_for_ci')->default(2)->after('ci_lifes')->comment('min teams req to start CI game');
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
            $table->dropColumn('min_teams_for_ci');
        });
    }
}
