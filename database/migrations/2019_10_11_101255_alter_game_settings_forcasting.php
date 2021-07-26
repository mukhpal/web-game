<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGameSettingsForcasting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->integer('weather_forecastinbg')->default('25')->after('round_team_cash')->comment('amount charge from player');
            $table->integer('economy_forecastinbg')->default('25')->after('weather_forecastinbg')->comment('amount charge from player');
            $table->integer('foreign_producer_forecastinbg')->default('25')->after('economy_forecastinbg')->comment('amount charge from player');
            $table->integer('max_loss_profit_limit')->default('20')->after('foreign_producer_forecastinbg')->comment('weather,economy impact limit, will be in percentage');
            $table->integer('market_demond')->default('1000')->after('max_loss_profit_limit')->comment('market demond for each round in LBS');
            $table->integer('market_cost')->default('1000')->after('market_demond')->comment('market cost against market demond');
            $table->string('foreign_production_amount')->default('500,1000,1500')->after('market_demond')->comment('comma saperated values in lbs');
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
            $table->dropColumn('weather_forecastinbg');
            $table->dropColumn('economy_forecastinbg');
            $table->dropColumn('max_loss_profit_limit');
            $table->dropColumn('market_demond');
            $table->dropColumn('market_cost');
            $table->dropColumn('foreign_production_amount');
            $table->dropColumn('foreign_producer_forecastinbg');
        });
    }
}