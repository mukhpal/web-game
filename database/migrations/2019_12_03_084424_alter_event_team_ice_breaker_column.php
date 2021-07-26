<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEventTeamIceBreakerColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_teams', function (Blueprint $table) {
            $table->integer('event_start_game_time')->after( 'ib_status' )->default(0);
            $table->integer('current_fun_fact_id')->after( 'event_start_game_time' )->default(0)->comment('0 when no funfact apeared');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crops', function (Blueprint $table) {
            $table->dropColumn('event_start_game_time');
            $table->dropColumn('current_fun_fact_id');
        });

        
    }
}
