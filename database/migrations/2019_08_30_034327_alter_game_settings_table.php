<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGameSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('single_question_time')->default('20')->after('team_size')->comment('time for a single questions in seconds only');
            $table->integer('answer_screen_time')->default('5')->after('single_question_time')->comment('time for answer screen in seconds only');
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
            $table->dropColumn('single_question_time');
            $table->dropColumn('answer_screen_time');
        });
    }
}
