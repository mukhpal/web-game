<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGameSettingsForecasting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->dropColumn('weather_forecastinbg');
            $table->dropColumn('economy_forecastinbg');
            $table->dropColumn('foreign_producer_forecastinbg');
            $table->decimal('forecasting_charge', 10, 2)->unsigned()->default(25)->comment('Amount will be charged for forecasting')->after( 'round_team_cash' );
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
            $table->dropColumn('forecasting_charge');
            $table->integer('chance_in_round')->default('2')->after('total_rounds')->comment('chances in a single round');
            $table->integer('chance_time')->default('30')->after('chance_in_round')->comment('time allocation for a chance in seconds');
            $table->integer('chance_result_time')->default('15')->after('chance_time')->comment('time to display results for a chance  in seconds');
            $table->integer('round_results_time')->default('30')->after('chance_result_time')->comment('time for a round answer screen  in seconds');
        });
    }
}
