<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEventJoinDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_join_details', function (Blueprint $table) {
            $table->integer('tutorials_seen')->after( 'socket_id' )->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_join_details', function (Blueprint $table) {
            $table->dropColumn('tutorials_seen');
        });
    }
}
