<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertEventTeamsTableForIbStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_teams', function (Blueprint $table) {
            $table->integer('ib_status')->default('1')->after('status')->comment('status of Ice Breaker game 2 if over/finished');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_teams', function (Blueprint $table) {
            $table->dropColumn('ib_status');
        });
    }
}
