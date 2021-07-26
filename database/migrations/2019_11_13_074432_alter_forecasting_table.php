<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterForecastingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forecasting', function (Blueprint $table) {
            $table->bigInteger('chance_id')->unsigned()->after( 'round_id' );
            $table->bigInteger('impact')->unsigned()->after( 'amount' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forecasting', function (Blueprint $table) {
            $table->dropColumn('chance_id');
            $table->dropColumn('impact');
        });
    }
}
