<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSettingsStatementTimer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('statement_screen_time')->default('2')->after('funfacts_screen_time')->comment('In minutes');
            $table->integer('statement_waiting_screen_time')->default('1')->after('statement_screen_time');
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
            $table->dropColumn('statement_screen_time');
            $table->dropColumn('statement_waiting_screen_time');
        });
    }
}
