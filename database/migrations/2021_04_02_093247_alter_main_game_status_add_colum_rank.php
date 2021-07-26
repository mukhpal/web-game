<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMainGameStatusAddColumRank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_game_status', function (Blueprint $table) {
            $table->integer('rank')->nullable()->after('status')->comment('Position of the team in the event');;
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('main_game_status', function (Blueprint $table) {
            $table->dropColumn('rank');
        });
    }
}
