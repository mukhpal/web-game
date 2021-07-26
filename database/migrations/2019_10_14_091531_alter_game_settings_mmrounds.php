<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGameSettingsMmrounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('total_rounds')->default('8')->after('foreign_production_amount')->comment('no of rounds in mm');
            $table->integer('chance_in_round')->default('2')->after('total_rounds')->comment('chances in a single round');
            $table->integer('chance_time')->default('30')->after('chance_in_round')->comment('time allocation for a chance in seconds');
            $table->integer('chance_result_time')->default('15')->after('chance_time')->comment('time to display results for a chance  in seconds');
            $table->integer('round_results_time')->default('30')->after('chance_result_time')->comment('time for a round answer screen  in seconds');
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
            $table->dropColumn('total_rounds');
            $table->dropColumn('chance_in_round');
            $table->dropColumn('chance_time');
            $table->dropColumn('chance_result_time');
            $table->dropColumn('round_results_time');
        });
    }
}
