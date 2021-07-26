<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGameSettingsIbTimings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('funfacts_screen_time')->default('2')->after('game_time')->comment('IB Game Fun Fact Screen Time (In minutes)');
            $table->integer('funfacts_waiting_screen_time')->default('1')->after('game_time')->comment('IB Game Fun Fact Waiting / Extra Time (In minutes)');
            $table->integer('ib_game_screen_time')->default('2')->after('game_time')->comment('IB Game Screen Time (In minutes)');
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
            $table->dropColumn('funfacts_screen_time');
            $table->dropColumn('funfacts_waiting_screen_time');
            $table->dropColumn('ib_game_screen_time');
        });
    }
}
