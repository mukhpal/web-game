<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AltergamesettingforIBtruthnlie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('ib_tl_game_time')->default('5')->after('answer_screen_time')->comment('Time for intro game played by event joined members (In minutes)');
            $table->integer('ib_tl_single_question_time')->default('30')->after('ib_tl_game_time')->comment('Time for quetion display inside the game');
            $table->integer('ib_tl_answer_screen_time')->default('20')->after('ib_tl_single_question_time')->comment('Time for answer displayed after question');
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
            $table->dropColumn('ib_tl_game_time');
            $table->dropColumn('ib_tl_single_question_time');
            $table->dropColumn('ib_tl_answer_screen_time');
        });
    }
}
