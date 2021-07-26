<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPlayerCashRenameColoumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player_cash', function (Blueprint $table) {
            $table->dropColumn('mmround_id');
            $table->bigInteger('event_id')->unsigned()->after( 'team_id' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_cash', function (Blueprint $table) {
            $table->dropColumn('event_id');
            $table->bigInteger('mmround_id')->unsigned()->after( 'team_id' );
        });
    }
}
