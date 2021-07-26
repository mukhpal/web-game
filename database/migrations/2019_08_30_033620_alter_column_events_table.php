<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('event_start_game_time')->nullable()->after('meeting_token')->comment();
            $table->integer('current_fun_fact_id')->default('0')->after('event_start_game_time')->comment('0 when no funfact apeared');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('event_start_game_time');
            $table->dropColumn('current_fun_fact_id');
        });
    }
}
